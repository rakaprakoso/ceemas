<?php

namespace rakadprakoso\cemas\models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'cms_posts';
}
