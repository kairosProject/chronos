<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Metadata\Process\Builder\Traits;

/**
 * Service name trait
 *
 * This trait is used to build a service registration name
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait ServiceNameTrait
{
    /**
     * Service name
     *
     * The service name. This value is used at definition registration time, concatenated to process name to define
     * service full name
     *
     * @var string
     */
    private $serviceName;

    /**
     * Build service name
     *
     * Return the builded service name
     *
     * @param string $processName The current process name
     *
     * @return string
     */
    protected function buildServiceName(string $processName) : string
    {
        return sprintf('%s_%s', $processName, $this->serviceName);
    }
}
