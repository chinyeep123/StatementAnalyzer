<?php
namespace Ant\StatementAnalyzer\Http\Controllers\Web;

use Ant\StatementAnalyzer\Http\Requests\ImportStatementRequest;
use Ant\StatementAnalyzer\Http\Requests\StoreStatementRequest;
use Ant\StatementAnalyzer\Http\Requests\UpdateStatementRequest;
use Ant\StatementAnalyzer\Http\Responses\Statements\DestroyResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\ImportCreateResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\ImportStoreResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\IndexResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\UpdateResponse;
use Ant\StatementAnalyzer\Imports\StatementImport;
use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementTag;
use Ant\StatementAnalyzer\Repositories\StatementRepository;
use Ant\StatementAnalyzer\Repositories\StatementTagRepository;
use App\Http\Controllers\Controller;
use App\Repositories\ImportExportRepository;
use App\Repositories\SystemRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StatementController extends Controller {

    /**
     * The statement repository instance.
     */
    protected $statementrepo;
    
    /**
     * The statement repository instance.
     */
    protected $statementtagrepo;

    public function __construct(
        StatementRepository $statementrepo,
        StatementTagRepository $statementtagrepo
    ) {

        //core controller instantation
        parent::__construct();

        //authenticated
        $this->middleware('auth');

        $this->middleware('statementsMiddlewareIndex')->only([
            'index',
            'update',
            'store',
            'import'
        ]);

        $this->middleware('statementsMiddlewareCreate')->only([
            'create',
            'store',
            'storeImport'
        ]);

        $this->middleware('statementsMiddlewareEdit')->only([
            'edit',
            'update',
        ]);

        $this->middleware('statementsMiddlewareDestroy')->only([
            'destroy',
        ]);

        //team only stuff
        $this->middleware('teamCheck')->only([
            'accountNumbers',
        ]);

        $this->statementrepo = $statementrepo;

        $this->statementtagrepo = $statementtagrepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        if(Request::ajax()) {
            $statements = $this->statementrepo->search();
            $stats = $this->statsWidget();
            $analysis = $this->statementrepo->search('', ['stats' => 'analysis']);
            return response()->json(compact('statements', 'stats', 'analysis'));
        }
        
        $settings = collect([
            'module' => 'statements',
            'module_tag' => 'statement-tags',
            'active_tab' => trans('lang.statements'),
            'source_for_filter_panels' => 'ext',
            'is_team' => auth()->user()->is_team,
            'can_import' => true,
            'url' => url('/'),
        ]);

        return view('statement-analyzer::index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {

        return view('statement-analyzer::create', compact('settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreStatementRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreStatementRequest $request) {
        $statement = Statement::create([
            'account_number' => $request->account_number,
            'date' => $request->date,
            'description' => $request->description,
            'debit_currency' => $request->debit_currency,
            'debit' => $request->debit,
            'credit_currency' => $request->credit_currency,
            'credit' => $request->credit,
            'balance_currency' => $request->balance_currency,
            'balance' => $request->balance,
        ]);
        $this->syncStatementTags($statement);

        $status = 200;
        $message = 'Data Created Successful!';
        return response()->json(compact('status', 'message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Statement  $statement
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Statement $statement) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Statement  $statement
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Statement $statement) {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStatementRequest  $request
     * @param  Statement  $statement
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Statement $statement, UpdateStatementRequest $request) {
        $statement->update([
            'account_number' => $request->account_number,
            'date' => $request->date,
            'description' => $request->description,
            'debit_currency' => $request->debit_currency,
            'debit' => $request->debit,
            'credit_currency' => $request->credit_currency,
            'credit' => $request->credit,
            'balance_currency' => $request->balance_currency,
            'balance' => $request->balance,
        ]);
        $this->syncStatementTags($statement);
        
        $status = 200;
        $message = 'Data Updated Successful!';
        return response()->json(compact('status', 'message'));
    }
    
    /**
     * destroy the specified resource.
     *
     * @param  Statement  $statement
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function destroy(Statement $statement) {
        $allrows = array();
        if($statement->id) {
            $statement->delete();
            $allrows[] = $statement->getKey();
            $statement->tags()->detach();
        }
        if(!empty(request('ids'))) {
            foreach (request('ids') as $id => $value) {
                //only checked items
                if ($value == 'on') {
                    //delete
                    $statement = Statement::findOrFail($id);
                    $statement->delete();
                    $statement->tags()->detach();
                    //add to array
                    $allrows[] = $id;
                }
            }
        }

        //reponse payload
        $payload = [
            'allrows' => $allrows,
            'stats' => $this->statsWidget(),
        ];
        return new DestroyResponse($payload);
    }

    /**
     * Show the form for importing a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function import(SystemRepository $systemrepo) {

        //check server requirements for excel module
        $server_check = $systemrepo->serverRequirementsExcel();
        
        //reponse payload
        $payload = [
            'type' => 'statements',
            'requirements' => $server_check['requirements'],
            'server_status' => $server_check['status'],
        ];

        //show the form
        return new ImportCreateResponse($payload);
    }
    
    /**
     * Import the specified resource in storage.
     *
     * @param  ImportStatementRequest  $request
     * @param  Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function storeImport(ImportStatementRequest $request, ImportExportRepository $importexportrepo) {
        //unique transaction ref
        $import_ref = str_unique();

        //uploaded file path
        $file_path = BASE_DIR . "/storage/temp/" . request('importing-file-uniqueid') . "/" . request('importing-file-name');
        
        //initial validation
        if (!$importexportrepo->validateImport()) {
            abort(409, __('lang.error_request_could_not_be_completed'));
        }

        //unique import ID (transaction tracking)
        request()->merge([
            'import_ref' => $import_ref,
        ]);
        
        $import = new StatementImport();
        $import->import($file_path);
        
        //log erors
        $importexportrepo->logImportError($import->failures(), $import_ref);
        
        //additional processing
        if ($import->getRowCount() > 0) {
            $this->processCollection();
        }

        //reponse payload
        $payload = [
            'type' => 'statements',
            'error_count' => count($import->failures()),
            'error_ref' => $import_ref,
            'count_passed' => $import->getRowCount(),
        ];

        //process reponse
        return new ImportStoreResponse($payload);
    }

    /**
     * ajax search results for account numbers
     * @permissions team members only
     * @return \Illuminate\Http\Response
     */
    public function accountNumbers(StatementRepository $statementrepo) {
        $feed = $this->statementrepo->autocompleteFeed('account_number', request('term'));

        return response()->json($feed);
    }

    protected function syncStatementTags($statement) {
        $tags = StatementTag::get();
        if($tags->count()) {
            $tag_ids = $tags->filter(function($tag) use($statement) {
                return Str::contains(Str::lower($statement->description), Str::lower($tag->name));
            })->pluck('id');

            $statement->tags()->sync($tag_ids->toArray());
        }
    }

    /**
     * additional processing for the imported collection
     */
    private function processCollection() {
        //get the statements for this import
        $statements = Statement::Where('importid', request('import_ref'))->get();
        foreach($statements as $statement) {
            $this->syncStatementTags($statement);
        }
    }

    /**
     * data for the stats widget
     * @return array
     */
    private function statsWidget($data = array()) {

        //stats
        $count_all = $this->statementrepo->search('', ['stats' => 'count-all']);
        $sum_debit = $this->statementrepo->search('', ['stats' => 'sum-debit']);
        $sum_credit = $this->statementrepo->search('', ['stats' => 'sum-credit']);
        $stats = [
            [
                'value' => $count_all,
                'title' => __('lang.count'),
                'percentage' => '100%',
                'color' => 'bg-info',
            ],
            [
                'value' => runtimeMoneyFormat($sum_debit),
                'title' => __('lang.debit'),
                'percentage' => '100%',
                'color' => 'bg-success',
            ],
            [
                'value' => runtimeMoneyFormat($sum_credit),
                'title' => __('lang.credit'),
                'percentage' => '100%',
                'color' => 'bg-warning',
            ],
            [
                'value' => runtimeMoneyFormat(0),
                'title' => "N",
                'percentage' => '100%',
                'color' => 'bg-danger',
            ],
        ];

        return $stats;
    }
}