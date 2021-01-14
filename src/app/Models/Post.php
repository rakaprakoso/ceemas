<?php

namespace Rakadprakoso\Ceemas\app\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'ceemas_posts';
}
