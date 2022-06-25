<?php

namespace Ant\StatementAnalyzer\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatementTag extends Model {

    use SoftDeletes;
    
    /**
     * @dateFormat string - date storage format
     */
    protected $table = 'statement_tags';
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'parent_id',
    ];

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
     * - the tags has belongToMany statements
     */
    public function statements() {
        return $this->belongsToMany(Statement::class);
    }

}
