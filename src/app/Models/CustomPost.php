<?php

namespace Rakadprakoso\Ceemas\app\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPost extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'ceemas_post_custom';

    public function post()
    {
    return $this->belongsTo('Rakadprakoso\Ceemas\app\Models\Post', 'foreign_key', 'other_key');
    }
}
