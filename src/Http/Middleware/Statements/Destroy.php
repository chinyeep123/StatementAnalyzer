<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [destroy] precheck processes for statements
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace Ant\StatementAnalyzer\Http\Middleware\Statements;

use Ant\StatementAnalyzer\Models\Statement;
use Closure;
use Log;

class Destroy {

    /**
     * This 'bulk actions' middleware does the following
     *   1. If the request was for a sinle item
     *         - single item actions must have a query string '?id=123'
     *         - this id will be merged into the expected 'ids' request array (just as if it was a bulk request)
     *   2. loop through all the 'ids' that are in the post request
     *
     * HTML for the checkbox is expected to be in this format:
     *   <input type="checkbox" name="ids[{{ $statement->statement_id }}]"
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //permission on each one
        if (auth()->user()->is_team) {
            if (auth()->user()->role->role_statements >= 3) {
                return $next($request);
            }else{
                abort(403);
            }
        }

        //client - no permissions
        if (auth()->user()->is_client) {
            abort(403);
        }
        //no items were passed with this request
        Log::error("no items were sent with this request", ['process' => '[permissions][statements][destroy]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'statement id' => $statement_id ?? '']);
        abort(409);
    }
}
