<?php

namespace Ant\StatementAnalyzer\Models;

use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class StatementStatementTag extends Model {

    /**
     * @dateFormat string - date storage format
     */
    protected $table = 'statement_statement_tag';
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'statement_id',
        'statement_tag_id',
    ];

    /**
     * relatioship business rules:
     * - belongsToMany specific statement
     */
    public function statement() {
        return $this->belongsToMany(Statement::class);
    }

    /**
     * relatioship business rules:
     * - belongsToMany specific tag
     */
    public function tag() {
        return $this->belongsToMany(StatementTag::class);
    }

}
