<?php

namespace Goth\LoadBalancer\HostInstance;

/**
 * HostInstance Interface
 *
 * @package Goth\LoadBalancer\HostInstance
 */
interface HostInstanceInterface
{
    /**
     * @return float
     */
    public function getLoad() : float;

    /**
     * @param $request
     */
    public function handleRequest($request);
}