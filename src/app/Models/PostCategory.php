<?php

namespace Rakadprakoso\Ceemas\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PostCategory extends Model
{
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%$search%");
    }
    public function scopeTag($query)
    {
        return $query->where('isCategory', null);
    }
    public function scopeCategory($query)
    {
        return $query->where('isCategory', '1');
    }
    /*protected static function booted()
    {
        static::addGlobalScope('isCategory', function (Builder $builder) {
            $builder->where('isCategory', '1');
        });
    }*/
    /*public function scopeCategory($query)
    {
        return $query->where('isCategory', '!=', null);
    }*/

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'ceemas_post_categories';
}
