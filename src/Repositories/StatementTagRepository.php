<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for statement tags
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace Ant\StatementAnalyzer\Repositories;

use Ant\StatementAnalyzer\Models\StatementTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class StatementTagRepository {

    /**
     * The statement tags repository instance.
     */
    protected $statement_tags;

    /**
     * Inject dependecies
     */
    public function __construct(StatementTag $statement_tags) {
        $this->statement_tags = $statement_tags;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @param array $data optional data payload
     * @return object expense collection
     */
    public function search($id = '', $data = array()) {

        $statement_tags = $this->statement_tags->newQuery();

        //default - always apply filters
        if (!isset($data['apply_filters'])) {
            $data['apply_filters'] = true;
        }

        //carbon dates
        $now = \Carbon\Carbon::now();
        $this_month = \Carbon\Carbon::now()->startOfMonth();

        //joins

        // all client fields
        $statement_tags->selectRaw('*');

        //default where
        $statement_tags->whereRaw("1 = 1");

        //filter by passed id
        if (is_numeric($id)) {
            $statement_tags->where('id', $id);
        }

        //filter by client - used for counting on external pages
        if (isset($data['project_clientid'])) {
            $statement_tags->where('project_clientid', $data['expense_clientid']);
        }

        //apply filters
        if ($data['apply_filters']) {
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('statement_tags', request('orderby'))) {
                $statement_tags->orderBy(request('orderby'), request('sortorder'));
            }
        } else {
            //default sorting
            $statement_tags->orderBy(
                'created_at',
                'desc'
            );
        }

        //eager load
        $statement_tags->with([
            'statements',
            'parent'
        ]);

        //stats 

        // return paginated rows
        return $statement_tags->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Create a new record
     * @return mixed int|bool
     */
    public function create() {
    }

    /**
     * update a record
     * @param int $id record id
     * @return mixed int|bool
     */
    public function update($id) {
    }

    /**
     * various feeds for ajax auto complete
     * @param string $type (parent)
     * @param string $searchterm
     * @return object client model object
     */
    public function autocompleteFeed($type = '', $searchterm = '') {
        //validation
        if ($type == '' || $searchterm == '') {
            return [];
        }

        //start
        $statement_tags = $this->statement_tags->newQuery();

        $statement_tags->selectRaw('name AS value, id');
        //feed: tags
        if ($type == 'parent') {
            $statement_tags->where('parent_id', 0);
            if($searchterm != 'empty') {
                $statement_tags->where('name', 'LIKE', '%' . $searchterm . '%');
            }
        } else if ($type == 'child') {
            $statement_tags->where('parent_id', $searchterm);
        } else{
            // if(!empty(request('parent_id'))) {
            //     $statement_tags->where('id', request('parent_id'));
            // } else {
                $statement_tags->where('name', 'LIKE', '%' . $searchterm . '%');
            // }
        }


        //return
        return $statement_tags->get();
    }

}