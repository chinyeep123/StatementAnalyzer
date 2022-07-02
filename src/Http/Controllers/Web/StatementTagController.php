<?php
namespace Ant\StatementAnalyzer\Http\Controllers\Web;

use Ant\StatementAnalyzer\Http\Requests\StoreStatementTagRequest;
use Ant\StatementAnalyzer\Http\Requests\UpdateStatementTagRequest;
use Ant\StatementAnalyzer\Http\Responses\StatementTags\DestroyResponse;
use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementTag;
use Ant\StatementAnalyzer\Repositories\StatementTagRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StatementTagController extends Controller {

    public function __construct(
        StatementTagRepository $statementtagrepo
    ) {

        //core controller instantation
        parent::__construct();

        //authenticated
        $this->middleware('auth');

        $this->middleware('statementTagsMiddlewareIndex')->only([
            'index',
            'update',
            'store',
        ]);

        $this->middleware('statementTagsMiddlewareCreate')->only([
            'create',
            'store',
        ]);

        $this->middleware('statementTagsMiddlewareEdit')->only([
            'edit',
            'update',
        ]);

        $this->middleware('statementTagsMiddlewareDestroy')->only([
            'destroy',
        ]);

        //team only stuff
        $this->middleware('teamCheck')->only([
            'all',
            'categories',
            'tags',
        ]);

        $this->statementtagrepo = $statementtagrepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        if(Request::ajax()) {
            $statement_tags = $this->statementtagrepo->search();
            return response()->json(compact('statement_tags'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {
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
     * @param  StatementTag  $statementTag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(StatementTag $statementTag) {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  StatementTag  $statementTag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(StatementTag $statementTag) {
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
        $allrows = array();
        if($statementTag->id) {
            $statementTag->delete();
            $allrows[] = $statementTag->getKey();
            $statementTag->statements()->detach();
        }
        
        //reponse payload
        $payload = [
            'allrows' => $allrows,
        ];
        return new DestroyResponse($payload);
    }

    /**
     * ajax search results for tags
     * @permissions team members only
     * @return \Illuminate\Http\Response
     */
    public function all(StatementTagRepository $statementtagrepo) {
        $term = request('parent_id') > 0? request('parent_id') : request('term');
        $feed = $statementtagrepo->autocompleteFeed('all', $term);

        return response()->json($feed);
    }

    /**
     * ajax search results for categories
     * @permissions team members only
     * @return \Illuminate\Http\Response
     */
    public function categories(StatementTagRepository $statementtagrepo) {
        $feed = $statementtagrepo->autocompleteFeed('parent', request('term'));

        return response()->json($feed);
    }

    /**
     * ajax search results for tags
     * @permissions team members only
     * @return \Illuminate\Http\Response
     */
    public function tags(StatementTagRepository $statementtagrepo) {
        $feed = $statementtagrepo->autocompleteFeed('child', request('parent_id'));

        return response()->json($feed);
    }

    protected function syncStatementTags($tag) {
        $statements = Statement::get();
        if($statements->count()) {
            $statement_ids = $statements->filter(function($statement) use($tag) {
                return Str::contains(Str::lower($statement->description), Str::lower($tag->name));
            })->pluck('id');
            $tag->statements()->sync($statement_ids->toArray());
        }
    }
}