<?php
namespace Ant\StatementAnalyzer\Http\Controllers\API;

use Ant\StatementAnalyzer\Http\Requests\StoreSatementTagRequest;
use Ant\StatementAnalyzer\Http\Requests\UpdateSatementTagRequest;
use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementTag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StatementTagController extends Controller {

    /**
     * Get Specific resources list in storage.
     *
     */
    public function getAll(Request $request) {
        // $query->selectRaw('client_company_name AS value, client_id AS id');
        // $query->where('client_company_name', 'LIKE', '%' . $searchterm . '%');
        // $feed = $clientrepo->autocompleteFeed('company_name', request('term'));
        $tags = StatementTag::where(function($query) {
                    if(!empty(Request::has('term'))) {
                        $query->where('name', 'LIKE', "%". Request::get('term') ."%");
                    }
                })
                ->selectRaw('name AS value, id')
                ->get();

        return response()->json($tags);
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
            $statement_ids = [];
            // $statement_ids = $statements->filter(function($tag) use($tag) {
            //     return Str::contains($statement->description, $tag->name);
            // })->pluck('id');
            foreach($statements as $statement) {
                if(Str::contains($statement->description, $tag->name)) {
                    array_push($statement_ids, $tag->getKey());
                }
            }
            $statement->statements()->sync($statement_ids);
        }
    }
}