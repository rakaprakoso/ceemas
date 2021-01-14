<?php

namespace Rakadprakoso\Ceemas\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


use Rakadprakoso\Ceemas\app\Scopes\GlobalDataScope;

class GlobalData extends Model
{
    /*protected $settings;
    protected $keyValuePair;
    protected $table = 'ceemas_config';

    public function __construct(Collection $settings){
        $this->settings = $settings;
        foreach ($settings as $setting){
            $this->keyValuePair[$setting->key] = $setting->value;
        }
    }

    public function has(string $key){ /* check key exists *-/ }
    public function contains(string $key){ /* check value exists *-/ }
    public function get(string $key){ /* get by key *-/ }*/
    /*protected static function booted()
    {
        static::addGlobalScope(new GlobalDataScope);
    }*/

    protected $table = 'ceemas_config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value'
    ];

    public function getData()
    {
        return "{$this}";
    }
}
