<?php

namespace Rakadprakoso\Ceemas\Services\ConfigService;

/**
 * Class DefaultConfigRepository
 *
 * @package Rakadprakoso\Ceemas\Services\ConfigService
 */
class DefaultConfigRepository implements ConfigRepository
{
    /**
     * LFM Route prefix
     * !!! WARNING - if you change it, you should compile frontend with new prefix(baseUrl) !!!
     *
     * @return string
     */
    public function getRoutePrefix(): string
    {
        return config('ceemas-config.routePrefix');
    }

    /**
     * Get disk list
     *
     * ['public', 'local', 's3']
     *
     * @return array
     */
    public function getDiskList(): array
    {
        if (\Session::get('role')=='1') {
            return config('file-manager.diskList');
        }

        return array_slice(config('file-manager.diskList'),0,1);
    }

    /**
     * Middleware
     *
     * Add your middleware name to array -> ['web', 'auth', 'admin']
     * !!!! RESTRICT ACCESS FOR NON ADMIN USERS !!!!
     *
     * @return array
     */
    public function getMiddleware(): array
    {
        return config('ceemas-config.middleware');
    }

}
