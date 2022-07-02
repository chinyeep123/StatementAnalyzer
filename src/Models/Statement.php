<?php

namespace Ant\StatementAnalyzer\Models;

use Ant\StatementAnalyzer\Models\StatementTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Statement extends Model {

    use SoftDeletes;
    
    /**
     * @dateFormat string - date storage format
     */
    protected $table = 'statements';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'importid',
        'account_number',
        'date',
        'description',
        'money_in_currency',
        'money_in',
        'money_out_currency',
        'money_out',
        'balance_currency',
        'balance',
    ];

    protected $hidden = ["created_at", "updated_at", "deleted_at"];

    /**
     * relatioship business rules:
     * - the tags has belongToMany tags
     */
    public function tags() {
        return $this->belongsToMany(StatementTag::class);
    }

}
