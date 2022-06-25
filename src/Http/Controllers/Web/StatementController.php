<?php
namespace Ant\StatementAnalyzer\Http\Controllers\Web;

use Ant\StatementAnalyzer\Http\Requests\ImportStatementRequest;
use Ant\StatementAnalyzer\Http\Requests\StoreStatementRequest;
use Ant\StatementAnalyzer\Http\Requests\UpdateStatementRequest;
use Ant\StatementAnalyzer\Http\Responses\Statements\DestroyResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\EditResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\ImportCreateResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\ImportStoreResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\IndexResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\UpdateResponse;
use Ant\StatementAnalyzer\Imports\StatementImport;
use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementTag;
use App\Http\Controllers\Controller;
use App\Repositories\ImportExportRepository;
use App\Repositories\SystemRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StatementController extends Controller {

    public function __construct(
    ) {

        //core controller instantation
        parent::__construct();

        //authenticated
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $query = new Statement();
        if(Request::ajax()) {
            if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
                //direct column name
                if (Schema::hasColumn('statements', request('orderby'))) {
                    $query = $query->orderBy(request('orderby'), request('sortorder'));
                } else {
                    $query = $query->orderByDesc('created_at');
                }
            }
            $statements = $query->paginate(config('system.settings_system_pagination_limits'));
            //reponse payload
            $payload = [
                'statements' => $statements,
                'stats' => $this->statsWidget(),
            ];
            return new IndexResponse($payload);
        }
        
        $settings = collect([
            'module' => 'statements',
            'module_tag' => 'statement-tags',
            'active_tab' => trans('lang.statements'),
            'source_for_filter_panels' => 'ext',
            'is_team' => auth()->user()->is_team,
            'can_import' => true,
            'url' => url('/'),
            'stats' => $this->statsWidget(),
            'statements' => $query->orderByDesc('created_at')->paginate(config('system.settings_system_pagination_limits'))
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
            'money_in_currency' => $request->money_in_currency,
            'money_in' => $request->money_in,
            'money_out_currency' => $request->money_out_currency,
            'money_out' => $request->money_out,
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
     * @param  Tag  $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag  $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id) {
        $statement = Statement::findOrFail($id);

        //reponse payload
        $payload = [
            'statement' => $statement,
        ];

        //response
        return new EditResponse($payload);
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
            'money_in_currency' => $request->money_in_currency,
            'money_in' => $request->money_in,
            'money_out_currency' => $request->money_out_currency,
            'money_out' => $request->money_out,
            'balance_currency' => $request->balance_currency,
            'balance' => $request->balance,
        ]);
        $this->syncStatementTags($statement);
        if($request->ref == 'list') {
            //reponse payload
            $payload = [
                'statements' => (new Statement())->paginate(config('system.settings_system_pagination_limits')),
                'stats' => $this->statsWidget(),
            ];

            //generate a response
            return new UpdateResponse($payload);
        }
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
        $sum_count_all = Statement::count();
        $sum_money_in = Statement::sum('money_in');
        $sum_money_out = Statement::sum('money_out');
        // $sum_all = Statement::selectRaw("statements.account_number, statements.balance, statements.created_at as latest_date")
        //                     // ->latest('latest_date')
        //                     ->orderByDesc('latest_date')
        //                     ->groupby(['statements.account_number'])
        //                     ->get();
        //default values
        $stats = [
            [
                'value' => $sum_count_all,
                'title' => __('lang.count'),
                'percentage' => '100%',
                'color' => 'bg-info',
            ],
            [
                'value' => runtimeMoneyFormat($sum_money_in),
                'title' => __('lang.money_in'),
                'percentage' => '100%',
                'color' => 'bg-success',
            ],
            [
                'value' => runtimeMoneyFormat($sum_money_out),
                'title' => __('lang.money_out'),
                'percentage' => '100%',
                'color' => 'bg-warning',
            ],
            [
                'value' => runtimeMoneyFormat(0),
                'title' => __('lang.balance'),
                'percentage' => '100%',
                'color' => 'bg-danger',
            ],
        ];

        return $stats;
    }
}