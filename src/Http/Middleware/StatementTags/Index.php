<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [index] precheck processes for statement_tags
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace Ant\StatementAnalyzer\Http\Middleware\StatementTags;

use Closure;
use Log;

class Index {

    /**
     * This middleware does the following
     *   2. checks users permissions to [view] statement_tags
     *   3. modifies the request object as needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //validate module status
        if (!config('visibility.modules.statement_tags')) {
            abort(404, __('lang.the_requested_service_not_found'));
            return $next($request);
        }

        //permission: does user have permission view statement_tags
        if (auth()->user()->is_team) {
            if (auth()->user()->role->role_statement_tags >= 1) {
                //limit to own statement_tags, if applicable
                return $next($request);
            }
        }

        //permission denied
        Log::error("permission denied", ['process' => '[permissions][statement_tags][index]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
}
