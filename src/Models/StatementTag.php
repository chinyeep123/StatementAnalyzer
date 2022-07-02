<?php

namespace Ant\StatementAnalyzer\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatementTag extends Model {

    use SoftDeletes;
    
    protected $table = 'statement_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'parent_id',
    ];

    protected $hidden = ["created_at", "updated_at", "deleted_at"];

    /**
     * return parent tags
     */
    public function scopeParent(Builder $builder) {
        return $builder->where('parent_id', false);
    } 
    
    /**
     * return children tags
     */
    public function scopeChild(Builder $builder) {
        return $builder->where('parent_id', '!=', false);
    }


    /**
     * relatioship business rules:
     * - the tags has belongsTo statement_tags
     */
    public function parent()
    {
        return $this->belongsTo(StatementTag::class, 'parent_id');
    }

    /**
     * relatioship business rules:
     * - the tags has belongToMany statements
     */
    public function statements() {
        return $this->belongsToMany(Statement::class);
    }

}
