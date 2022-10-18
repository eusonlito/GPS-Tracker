<?php declare(strict_types=1);

/**
 * @return \App\Services\Helper\Helper
 */
function helper(): App\Services\Helper\Helper
{
    static $helper;

    return $helper ??= new App\Services\Helper\Helper();
}

/**
 * @return \App\Services\Helper\Service
 */
function service(): App\Services\Helper\Service
{
    static $service;

    return $service ??= new App\Services\Helper\Service();
}
