<?php

namespace Goth\LoadBalancer;

use Goth\LoadBalancer\Algorithm\LoadBalancingAlgorithmInterface;
use Goth\LoadBalancer\HostInstance\HostInstanceInterface;
use Goth\LoadBalancer\HostInstance\HostInstanceValidator;

/**
 * LoadBalancer Class
 *
 * @package Goth\LoadBalancer
 */
class LoadBalancer
{
    /**
     * The list of host instances that should be load balanced
     *
     * @var HostInstanceInterface[]
     */
    protected $hostInstances;

    /**
     * The variant of load balancing algorithm to be used
     *
     * @var LoadBalancingAlgorithmInterface
     */
    protected $algorithm;

    /**
     * LoadBalancer constructor
     *
     * @param HostInstanceInterface[] $hostInstances
     * @param LoadBalancingAlgorithmInterface $algorithm
     */
    public function __construct(array $hostInstances, LoadBalancingAlgorithmInterface $algorithm)
    {
        HostInstanceValidator::validateList($hostInstances);

        $this->hostInstances = $hostInstances;
        $this->algorithm = $algorithm;
    }

    /**
     * Load balances the request according to the algorithm passed on construction
     *
     * @param $request
     */
    public function handleRequest($request)
    {
        $this->algorithm->getHost($this->hostInstances)->handleRequest($request);
    }
}