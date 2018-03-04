<?php

namespace Goth\LoadBalancer\Algorithm;

use Goth\LoadBalancer\HostInstance\HostInstanceInterface;
use Goth\LoadBalancer\HostInstance\HostInstanceValidator;

/**
 * SequenceAlgorithm Class
 *
 * The algorithm returns the instances sequentially in rotation
 *
 * @package Goth\LoadBalancer\Algorithm
 */
class SequenceAlgorithm implements LoadBalancingAlgorithmInterface
{
    /**
     * The recently returned host instance index
     *
     * @var integer
     */
    private $currentHostInstanceIndex = 0;

    /**
     * @param HostInstanceInterface[] $hostInstances
     *
     * @return HostInstanceInterface
     */
    public function getHost(array $hostInstances) : HostInstanceInterface
    {
        HostInstanceValidator::validateList($hostInstances);

        $hostInstancesLength = count($hostInstances);

        $rotationIndex = $this->currentHostInstanceIndex < $hostInstancesLength ? $this->currentHostInstanceIndex : 0;

        $this->currentHostInstanceIndex = ($this->currentHostInstanceIndex + 1) % $hostInstancesLength;

        return $hostInstances[$rotationIndex];
    }
}