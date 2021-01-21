<?php

namespace Rakadprakoso\Ceemas\app;

use Rakadprakoso\Ceemas\app\models\PostCategory as Model;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Rakadprakoso\Ceemas\app\Traits\helper;
//
class PostCategory
{


    public function data()
    {
        $data['category'] = Model::category()->get();
        $data['tag'] = Model::tag()->get();

        return $data;
    }

}
