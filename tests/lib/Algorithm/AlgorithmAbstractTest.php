<?php

namespace Goth\LoadBalancer\Tests\Algorithm;

use Goth\LoadBalancer\Algorithm\LoadBalancingAlgorithmInterface;
use Goth\LoadBalancer\HostInstance\HostInstanceInterface;
use PHPUnit\Framework\TestCase;

abstract class AlgorithmAbstractTest extends TestCase
{
    /**
     * Creates the HostInstanceInterface object with given load
     *
     * @param $load
     *
     * @return HostInstanceInterface
     */
    protected function createHostInstance($load) : HostInstanceInterface
    {
        return new class($load) implements HostInstanceInterface {
            private $load;

            public function __construct(float $load)
            {
                $this->load = $load;
            }

            public function getLoad() : float
            {
                return $this->load;
            }

            public function handleRequest($request)
            {
                return $request;
            }
        };
    }

    public function testGetHostWithEmptyHostInstancesArray()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->getAlgorithm()->getHost(array());
    }

    public function testGetHostWithWrongHostInstanceTypesArray()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->getAlgorithm()->getHost(array());
    }

    public abstract function getAlgorithm() : LoadBalancingAlgorithmInterface;
}