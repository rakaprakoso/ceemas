<?php

use Rakadprakoso\Ceemas\Services\ConfigService\DefaultConfigRepository;

return [

    /**
     * Set Config repository
     *
     * Default - DefaultConfigRepository get config from this file
     */
    'configRepository' => DefaultConfigRepository::class,

    //********* Default configuration for DefaultConfigRepository **************

    /**
     * LFM Route prefix
     * !!! WARNING - if you change it, you should compile frontend with new prefix(baseUrl) !!!
     */
    'routePrefix' => 'ceemas',

    /**
     * List of disk names that you want to use
     * (from config/filesystems)
     */
    'diskList' => ['public','resources_views','project' ],

    /***************************************************************************
     * Middleware
     *
     * Add your middleware name to array -> ['web', 'auth', 'admin']
     * !!!! RESTRICT ACCESS FOR NON ADMIN USERS !!!!
     */
    'middleware' => ['web'],

];
