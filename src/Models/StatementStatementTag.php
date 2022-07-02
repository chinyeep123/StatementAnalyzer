<?php

namespace Ant\StatementAnalyzer\Models;

use Ant\StatementAnalyzer\Models\Statement;
use Ant\StatementAnalyzer\Models\StatementTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class StatementStatementTag extends Model {

    protected $table = 'statement_statement_tag';

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
     * - belongsTo specific statement
     */
    public function statement() {
        return $this->belongsTo(Statement::class, 'statement_id');
    }

    /**
     * relatioship business rules:
     * - belongsTo specific tag
     */
    public function tag() {
        return $this->belongsTo(StatementTag::class, 'statement_tag_id');
    }

}
