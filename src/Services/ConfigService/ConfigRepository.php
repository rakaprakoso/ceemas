<?php

namespace Rakadprakoso\Ceemas\Services\ConfigService;

/**
 * Interface ConfigRepository
 *
 * @package Rakadprakoso\Ceemas\Services\ConfigService
 */
interface ConfigRepository
{
    /**
     * LFM Route prefix
     * !!! WARNING - if you change it, you should compile frontend with new prefix(baseUrl) !!!
     *
     * @return string
     */
    public function getRoutePrefix(): string;

    /**
     * Get disk list
     *
     * ['public', 'local', 's3']
     *
     * @return array
     */
    public function getDiskList(): array;

    /**
     * Middleware
     *
     * Add your middleware name to array -> ['web', 'auth', 'admin']
     * !!!! RESTRICT ACCESS FOR NON ADMIN USERS !!!!
     *
     * @return array
     */
    public function getMiddleware(): array;

}
