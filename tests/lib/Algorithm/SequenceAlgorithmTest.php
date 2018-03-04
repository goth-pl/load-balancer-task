<?php

namespace Goth\LoadBalancer\Tests\Algorithm;

use Goth\LoadBalancer\Algorithm\LoadBalancingAlgorithmInterface;
use Goth\LoadBalancer\Algorithm\SequenceAlgorithm;
use Goth\LoadBalancer\HostInstance\HostInstanceInterface;
use Goth\LoadBalancer\Tests\AbstractTest;

class SequenceAlgorithmTest extends AlgorithmAbstractTest
{
    /**
     * @var SequenceAlgorithm
     */
    private static $algorithm;

    public static function setUpBeforeClass()
    {
        self::$algorithm = new SequenceAlgorithm();
    }

    /**
     * @dataProvider getHostProvider
     *
     * @param HostInstanceInterface[] $hostInstances
     * @param HostInstanceInterface $expected
     */
    public function testGetHost(array $hostInstances, HostInstanceInterface $expected)
    {
        $this->assertEquals($expected, self::$algorithm->getHost($hostInstances));
    }

    public function getHostProvider() : array
    {
        $hostInstances = [
            $this->createHostInstance(0.5),
            $this->createHostInstance(0.1),
            $this->createHostInstance(0.2),
            $this->createHostInstance(0.7)
        ];

        return [
            [
                $hostInstances,
                $hostInstances[0]
            ],
            [
                $hostInstances,
                $hostInstances[1]
            ],
            [
                $hostInstances,
                $hostInstances[2]
            ],
            [
                $hostInstances,
                $hostInstances[3]
            ],
            [
                $hostInstances,
                $hostInstances[0]
            ],
            [
                [$hostInstances[0]],
                $hostInstances[0]
            ]
        ];
    }

    public function getAlgorithm() : LoadBalancingAlgorithmInterface
    {
        return self::$algorithm;
    }
}