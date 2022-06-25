<?php
namespace Ant\StatementAnalyzer\Http\Controllers\Web;

use Ant\StatementAnalyzer\Http\Requests\StoreStatementTagRequest;
use Ant\StatementAnalyzer\Http\Requests\UpdateStatementTagRequest;
use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementTag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StatementTagController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $settings = collect([
            'module' => 'statement-tags',
            'tabs' => collect([
                ['name' => 'Statements']
            ]),
            'active_tab' => trans('lang.statement_tags'),
            'source_for_filter_panels' => 'ext',
            'is_team' => auth()->user()->is_team,
            'url' => url('/'),
            'statement_tags' => StatementTag::orderByDesc('created_at')->get()
        ]);
        return view('statement-analyzer::tags.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {
        $settings = collect([
            'module' => 'statement-tags',
            'tabs' => collect([
                ['name' => 'Statement Tags']
            ]),
            'active_tab' => trans('lang.statement_tags'),
            'source_for_filter_panels' => 'ext',
            'is_team' => auth()->user()->is_team,
            'url' => url('/'),
        ]);

        // $html = view('pages/payments/components/modals/add-edit-inc', compact('page', 'invoice'))->render();
        // $jsondata['dom_html'][] = array(
        //     'selector' => '#commonModalBody',
        //     'action' => 'replace',
        //     'value' => $html);
        // return view('statement-analyzer::tags.create', compact('settings'));
        
        //render the form
        $html = view('statement-analyzer::tags.create')->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html);

        //show modal footer
        $jsondata['dom_visibility'][] = array('selector' => '#commonModalFooter', 'action' => 'show');

        // POSTRUN FUNCTIONS------
        $jsondata['postrun_functions'][] = [
            'value' => 'NXStatementTagCreate',
        ];

        //ajax response
        return response()->json($jsondata);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreStatementTagRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreStatementTagRequest $request) {
        $result = false;
        $statementTag = StatementTag::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id? $request->parent_id : 0,
        ]);
        $this->syncStatementTags($statementTag);

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
        
        return view('statement-analyzer::tags.show', compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag  $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit() {

        return view('statement-analyzer::tags.edit', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStatementTagRequest  $request
     * @param  StatementTag  $statementTag
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StatementTag $statementTag, UpdateStatementTagRequest $request) {
        $statementTag->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);
        $this->syncStatementTags($statementTag);

        $status = 200;
        $message = 'Data Updated Successful!';
        return response()->json(compact('status', 'message'));
    }
    
    /**
     * destroy the specified resource.
     *
     * @param  StatementTag  $statementTag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function destroy(StatementTag $statementTag) {
        $statementTag->delete();
        $statementTag->statements()->detach();

        $status = 200;
        $message = 'Data Deleted Successful!';
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));
        return response()->json(compact('status', 'message'));
    }

    protected function syncStatementTags($tag) {
        $statements = Statement::get();
        if($statements->count()) {
            $statement_ids = $statements->filter(function($statement) use($tag) {
                return Str::contains(Str::lower($tag->name), Str::lower($statement->description));
            })->pluck('id');
            $tag->statements()->sync($statement_ids->toArray());
        }
    }
}