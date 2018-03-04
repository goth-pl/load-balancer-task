<?php

namespace Goth\LoadBalancer\Algorithm;

use Goth\LoadBalancer\HostInstance\HostInstanceInterface;

/**
 * LoadBalancingAlgorithm Interface
 *
 * @package Goth\LoadBalancer\Algorithm
 */
interface LoadBalancingAlgorithmInterface
{
    /**
     * @param HostInstanceInterface[] $hostInstances
     *
     * @return HostInstanceInterface
     */
    public function getHost(array $hostInstances) : HostInstanceInterface;
}