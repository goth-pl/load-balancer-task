<?php

namespace Goth\LoadBalancer\Tests;

use PHPUnit\Framework\TestCase;

use Goth\LoadBalancer\Algorithm\SequenceAlgorithm;
use Goth\LoadBalancer\LoadBalancer;

class LoadBalancerTest extends TestCase
{
    public function testConstructWithEmptyHostInstancesArray()
    {
        $this->expectException(\InvalidArgumentException::class);

        new LoadBalancer(array(), new SequenceAlgorithm());
    }

    public function testConstructWithWrongHostInstanceTypesArray()
    {
        $this->expectException(\InvalidArgumentException::class);

        new LoadBalancer(array(new \stdClass()), new SequenceAlgorithm());
    }

    public function testHandleRequest()
    {
        $algorithm = new SequenceAlgorithm();
        $hostInstance = $this->createMock('Goth\LoadBalancer\HostInstance\HostInstanceInterface');

        $loadBalancer = new LoadBalancer([$hostInstance], $algorithm);

        $hostInstance->expects($this->once())->method('handleRequest');

        $loadBalancer->handleRequest(array());
    }
}