<?php

namespace Rakadprakoso\Ceemas\app\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class GlobalDataScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        //$builder->pluck('value','key');
        $builder->eachById('key');
    }
}
