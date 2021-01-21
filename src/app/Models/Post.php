<?php

namespace Rakadprakoso\Ceemas\app\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'ceemas_posts';
    public function categories()
    {
        return $this->belongsToMany('Rakadprakoso\Ceemas\app\Models\PostCategory',
        'ceemas_post_post_category', 'post_id', 'category_id');
    }
}
