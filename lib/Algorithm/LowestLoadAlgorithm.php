<?php

namespace Goth\LoadBalancer\Algorithm;

use Goth\LoadBalancer\HostInstance\HostInstanceInterface;
use Goth\LoadBalancer\HostInstance\HostInstanceValidator;

/**
 * LowestLoadAlgorithm Class
 *
 * The algorithm returns either the first host that has a load under 0.75
 * or if all hosts are above 0.75, it returns the one with the lowest load
 *
 * @package Goth\LoadBalancer\Algorithm
 */
class LowestLoadAlgorithm implements LoadBalancingAlgorithmInterface
{
    const BOUNDARY_LOAD = 0.75;

    /**
     * @param HostInstanceInterface[] $hostInstances
     *
     * @return HostInstanceInterface
     */
    public function getHost(array $hostInstances) : HostInstanceInterface
    {
        HostInstanceValidator::validateList($hostInstances);

        $instanceUnderBoundaryLoad = $this->findInstanceUnderBoundaryLoad($hostInstances);

        if (null !== $instanceUnderBoundaryLoad) {
            return $instanceUnderBoundaryLoad;
        }

        return $this->findLowestLoadInstance($hostInstances);
    }

    /**
     * Returns the first instance whose load is under the boundary load. Otherwise returns null.
     *
     * @param HostInstanceInterface[] $hostInstances
     *
     * @return HostInstanceInterface|null
     */
    private function findInstanceUnderBoundaryLoad(array $hostInstances) : ?HostInstanceInterface
    {
        foreach ($hostInstances as $instance) {
            if ($instance->getLoad() < self::BOUNDARY_LOAD) {
                return $instance;
            }
        }

        return null;
    }

    /**
     * Returns the instance with the lowest load
     *
     * @param HostInstanceInterface[] $hostInstances
     *
     * @return HostInstanceInterface
     */
    private function findLowestLoadInstance(array $hostInstances) : HostInstanceInterface
    {
        $lowestLoadInstance = null;

        foreach ($hostInstances as $instance) {
            if (null === $lowestLoadInstance || $instance->getLoad() < $lowestLoadInstance->getLoad()) {
                $lowestLoadInstance = $instance;
            }
        }

        return $lowestLoadInstance;
    }
}