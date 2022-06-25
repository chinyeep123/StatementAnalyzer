<?php
namespace Ant\StatementAnalyzer\Http\Controllers\API;

use Ant\StatementAnalyzer\Http\Requests\ImportStatementRequest;
use Ant\StatementAnalyzer\Http\Requests\StoreStatementRequest;
use Ant\StatementAnalyzer\Http\Requests\UpdateStatementRequest;
use Ant\StatementAnalyzer\Http\Responses\Statements\DestroyResponse;
use Ant\StatementAnalyzer\Http\Responses\Statements\IndexResponse;
use Ant\StatementAnalyzer\Imports\StatementImport;
use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementTag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class StatementAnalyzerController extends Controller {

    public function __construct(
    ) {

        //core controller instantation
        parent::__construct();

        //authenticated
        // $this->middleware('auth');
    }
    /**
     * Get Specific resources list in storage.
     *
     */
    public function getAll(Request $request) {
        // $query->selectRaw('client_company_name AS value, client_id AS id');
        // $query->where('client_company_name', 'LIKE', '%' . $searchterm . '%');
        // $feed = $clientrepo->autocompleteFeed('company_name', request('term'));
        $statements = Statement::where(function($query) {
                    if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
                        //direct column name
                        if (Schema::hasColumn('statements', request('orderby'))) {
                            $query->orderBy(request('orderby'), request('sortorder'));
                        }
                    }
                })
                ->paginate(config('system.settings_system_pagination_limits'));
        
        //reponse payload
        $payload = [
            'statements' => $statements,
            'stats' => $this->statsWidget(),
        ];
        return new IndexResponse($payload);
        // return response()->json($statements);
    }

    /**
     * data for the stats widget
     * @return array
     */
    private function statsWidget($data = array()) {

        //stats
        $count_all = Statement::sum('balance');

        //default values
        $stats = [
            [
                'value' => $count_all,
                'title' => __('lang.count'),
                'percentage' => '100%',
                'color' => 'bg-info',
            ],
        ];

        return $stats;
    }

    protected function syncStatementTags($statement) {
        $tags = StatementTag::get();
        if($tags->count()) {
            $tag_ids = [];
            // $tag_ids = $tags->filter(function($tag) use($statement) {
            //     return Str::contains($statement->description, $tag->name);
            // })->pluck('id');
            foreach($tags as $tag) {
                if(Str::contains($statement->description, $tag->name)) {
                    array_push($tag_ids, $tag->getKey());
                }
            }
            $statement->tags()->sync($tag_ids);
        }
    }
}