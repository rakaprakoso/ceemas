<?php

namespace Rakadprakoso\Ceemas\app\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', "%$search%");
    }
    public function scopePost($query)
    {
        return $query->where('isPage', null)->orWhere('isPage', '0');
    }
    public function scopePage($query)
    {
        return $query->where('isPage', '1');
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'ceemas_posts';

    public function categories()
    {
        return $this->belongsToMany('Rakadprakoso\Ceemas\app\Models\PostCategory',
        'ceemas_post_post_category', 'post_id', 'category_id');
    }
    public function custom_content()
    {
        return $this->hasOne('Rakadprakoso\Ceemas\app\Models\CustomPost','post_id','id');
    }
}
