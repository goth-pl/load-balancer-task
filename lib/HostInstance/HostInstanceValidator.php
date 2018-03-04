<?php

namespace Goth\LoadBalancer\HostInstance;

/**
 * HostInstanceValidator Class
 *
 * @package Goth\LoadBalancer\HostInstance
 */
class HostInstanceValidator
{
    /**
     * Validates a list of host instances
     *
     * @param HostInstanceInterface[] $hostInstances
     *
     * @throws \InvalidArgumentException if the given array is empty
     * @throws \InvalidArgumentException if at least one of the array elements is not an object of HostInstanceInterface
     */
    public static function validateList(array $hostInstances)
    {
        if (empty($hostInstances)) {
            throw new \InvalidArgumentException('Host instances array should not be empty.');
        }

        foreach ($hostInstances as $instance) {
            if (!$instance instanceof HostInstanceInterface) {
                throw new \InvalidArgumentException('Host instance should be an object of HostInstanceInterface.');
            }
        }
    }
}