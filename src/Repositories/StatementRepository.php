<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for statements
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace Ant\StatementAnalyzer\Repositories;

use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementStatementTag;
use Ant\StatementAnalyzer\Models\StatementTag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class StatementRepository {

    /**
     * The statements repository instance.
     */
    protected $statements;

    /**
     * Inject dependecies
     */
    public function __construct(Statement $statements) {
        $this->statements = $statements;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @param array $data optional data payload
     * @return object expense collection
     */
    public function search($id = '', $data = array()) {

        $statements = $this->statements->newQuery();

        //default - always apply filters
        if (!isset($data['apply_filters'])) {
            $data['apply_filters'] = true;
        }

        //joins

        // all client fields
        $statements->selectRaw('*');

        //default where
        $statements->whereRaw("1 = 1");

        //apply filters
        if ($data['apply_filters']) {
            //filter tag
            if (is_array(request('tag_ids')) && $data['apply_filters']) {
                $statements->whereHas('tags', function ($query) {
                    $query->whereIn('statement_tag_id', request('tag_ids'));
                });
            }

            //filter category
            if (request()->filled('category_id') && empty(request('tag_ids')) && $data['apply_filters']) {
                $statements->whereHas('tags', function ($query) {
                    $child_ids = StatementTag::where('parent_id', request('category_id'))->pluck('id');
                    $query->where('statement_tag_id', request('category_id'))
                        ->orWhereIn('statement_tag_id', $child_ids);
                });
            }

            //filters: account_number
            if (request()->filled('account_number') && $data['apply_filters']) {
                $statements->where('account_number', request('account_number'));
            }

            //filters: get results without tags
            if(request()->filled('without_tag') && $data['apply_filters']) {
                if(request('without_tag') == true) {
                    $statement_ids = StatementStatementTag::pluck('statement_id');
                    $statements->whereNotIn('id', $statement_ids);
                }
            }

            //search: various client columns and relationships (where first, then wherehas)
            if (request()->filled('search_query')) {
                $statements->where(function ($query) {
                    $query->Where('id', '=', request('search_query'));
                    if (is_numeric(request('search_query'))) {
                        $query->orWhere('debit', '=', request('search_query'));
                        $query->orWhere('credit', '=', request('search_query'));
                        $query->orWhere('balance', '=', request('search_query'));
                    }
                    $query->orWhere('date', '=', date('Y-m-d', strtotime(request('search_query'))));
                    $query->orWhere('debit_currency', '=', request('search_query'));
                    $query->orWhere('credit_currency', '=', request('search_query'));
                    $query->orWhere('balance_currency', '=', request('search_query'));
                    $query->orWhere('description', 'LIKE', '%' . request('search_query') . '%');
                });
            }
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('statements', request('orderby'))) {
                $statements->orderBy(request('orderby'), request('sortorder'));
            }
        } else {
            //default sorting
            $statements->orderBy(
                'created_at',
                'desc'
            );
        }

        //eager load
        $statements->with([
            'tags',
        ]);

        //stats - count all
        if (isset($data['stats']) && $data['stats'] == 'count-all') {
            return $statements->count();
        }
        //stats - sum all
        if (isset($data['stats'])) {
            if(in_array($data['stats'], [
                'sum-debit',
            ])) {
                return $statements->sum('debit');
            } else if(in_array($data['stats'], [
                'sum-credit',
            ])) {
                return $statements->sum('credit');
            } else if(in_array($data['stats'], [
                'statement_analysis_ids',
            ])) {
                return $statements->pluck('id');
            } else if(in_array($data['stats'], [
                'analysis',
            ])) {
                $statement_ids = $statements->pluck('id');
                $statements = $statements->get();
                $statement_tag_ids = StatementStatementTag::whereIn('statement_id', $statement_ids)
                                                                ->groupBy(['statement_tag_id'])
                                                                ->pluck('statement_tag_id');
                $tags = StatementTag::whereIn('id', $statement_tag_ids)
                                            ->get();
                $arr = [];
                // dd($tags);
                foreach($tags as $tag) {
                    // dd($tag);
                    if($tag->parent_id) {
                        $parent = StatementTag::findOrFail($tag->parent_id);
                        $statement = Statement::leftJoin('statement_statement_tag', 'statement_statement_tag.statement_id', '=', 'statements.id')
                                        ->where('statement_statement_tag.statement_tag_id', $tag->id)
                                        ->selectRaw('SUM(statements.debit) as debit, SUM(statements.credit) as credit')
                                        ->first();
                        if(!empty($arr[$parent->name])) {
                            array_push($arr[$parent->name]['childs'],
                            [
                                'name' => $tag->name,
                                'debit' => $statement->debit,
                                'credit' => $statement->credit,
                            ]);
                        } else {
                            $arr[$parent->name] = [
                                'name' => $parent->name,
                                'debit' => '',
                                'credit' => '',
                                'balance' => '',
                                'childs' => [
                                    [
                                        'name' => $tag->name,
                                        'debit' => $statement->debit,
                                        'credit' => $statement->credit,
                                    ]
                                ]
                            ];
                        }
                    } else {
                        $statement = Statement::leftJoin('statement_statement_tag', 'statement_statement_tag.statement_id', '=', 'statements.id')
                                        ->where('statement_statement_tag.statement_tag_id', $tag->id)
                                        ->selectRaw('SUM(statements.debit) as debit, SUM(statements.credit) as credit')
                                        ->first();
                        $arr[$tag->name] = [
                            'name' => $tag->name,
                            'debit' => $statement->debit,
                            'credit' => $statement->credit,
                        ];
                    }
                }
                return $arr;
            }
        }

        // return paginated rows
        return $statements->paginate(config('system.settings_system_pagination_limits'));
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
     * @param string $type (account_number)
     * @param string $searchterm
     * @return object client model object
     */
    public function autocompleteFeed($type = '', $searchterm = '') {

        //validation
        if ($type == '' || $searchterm == '') {
            return [];
        }

        //start
        $query = $this->statements->newQuery();

        //feed: account numbers
        if ($type == 'account_number') {
            $query->selectRaw('account_number AS value, account_number AS id');
            $query->where('account_number', 'LIKE', '%' . $searchterm . '%');
        }

        //return
        return $query->groupBy('account_number')->get();
    }

}