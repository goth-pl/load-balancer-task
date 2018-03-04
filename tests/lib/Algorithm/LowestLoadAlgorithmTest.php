<?php

namespace Goth\LoadBalancer\Tests\Algorithm;

use Goth\LoadBalancer\Algorithm\LoadBalancingAlgorithmInterface;
use Goth\LoadBalancer\Algorithm\LowestLoadAlgorithm;
use Goth\LoadBalancer\HostInstance\HostInstanceInterface;

class LowestLoadAlgorithmTestTest extends AlgorithmAbstractTest
{
    /**
     * @dataProvider getHostProvider
     *
     * @param HostInstanceInterface[] $hostInstances
     * @param HostInstanceInterface $expected
     */
    public function testGetHost(array $hostInstances, HostInstanceInterface $expected)
    {
        $this->assertEquals($expected, $this->getAlgorithm()->getHost($hostInstances));
    }

    public function testGetHostWithEmptyHostInstancesArray()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->getAlgorithm()->getHost(array());
    }

    public function testGetHostWithWrongHostInstanceTypesArray()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->getAlgorithm()->getHost(array(new \stdClass()));
    }

    public function testFindInstanceUnderBoundaryLoad()
    {
        $hostInstances = [
            $this->createHostInstance(0.7),
            $this->createHostInstance(0.93),
            $this->createHostInstance(0.85),
            $this->createHostInstance(0.4),
            $this->createHostInstance(0.25)
        ];

        $expected = $hostInstances[0];
        $algorithm = $this->getAlgorithm();
        $result = $this->invokeMethod($algorithm, 'findInstanceUnderBoundaryLoad', array($hostInstances));

        $this->assertEquals($expected, $result);
    }

    public function testFindLowestLoadInstance()
    {
        $hostInstances = [
            $this->createHostInstance(0.94),
            $this->createHostInstance(0.93),
            $this->createHostInstance(0.85),
            $this->createHostInstance(0.88),
            $this->createHostInstance(0.99)
        ];

        $expected = $hostInstances[2];
        $algorithm = $this->getAlgorithm();
        $result = $this->invokeMethod($algorithm, 'findLowestLoadInstance', array($hostInstances));

        $this->assertEquals($expected, $result);
    }

    /**
     * Calls protected/private method of a class.
     *
     * @param object &$object
     * @param string $methodName
     * @param array $parameters
     *
     * @return mixed
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * @return array
     */
    public function getHostProvider() : array
    {
        $mixLoadsHostInstances = [
            $this->createHostInstance(0.7),
            $this->createHostInstance(0.93),
            $this->createHostInstance(0.85),
            $this->createHostInstance(0.4),
            $this->createHostInstance(0.25)
        ];

        $highLoadsHostInstances = [
            $this->createHostInstance(0.81),
            $this->createHostInstance(0.93),
            $this->createHostInstance(0.79),
            $this->createHostInstance(0.82),
            $this->createHostInstance(0.92)
        ];

        return [
            [
                $mixLoadsHostInstances,
                $mixLoadsHostInstances[0]
            ],
            [
                $highLoadsHostInstances,
                $highLoadsHostInstances[2]
            ]
        ];
    }

    public function getAlgorithm() : LoadBalancingAlgorithmInterface
    {
        return new LowestLoadAlgorithm();
    }
}