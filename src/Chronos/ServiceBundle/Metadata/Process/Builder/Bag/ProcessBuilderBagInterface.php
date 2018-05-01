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
namespace Chronos\ServiceBundle\Metadata\Process\Builder\Bag;

/**
 * Process builder bag interface
 *
 * This interface is used to define the process builder bag methods
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ProcessBuilderBagInterface
{
    /**
     * Set process name
     *
     * Set the current process name
     *
     * @param string $name The current process name
     *
     * @return self
     */
    public function setProcessName(string $name) : ProcessBuilderBagInterface;

    /**
     * Get process name
     *
     * Return the current process name
     *
     * @return string
     */
    public function getProcessName() : string;

    /**
     * Set dispatcher service name
     *
     * Store the dispatcher definition service name
     *
     * @param string $serviceName The dispatcher service definition name
     *
     * @return self
     */
    public function setDispatcherServiceName(string $serviceName) : ProcessBuilderBagInterface;

    /**
     * Get dispatcher service name
     *
     * Return the defined dispatcher service name or null if not defined
     *
     * @return string|NULL
     */
    public function getDispatcherServiceName() : ?string;

    /**
     * Set serializer service name
     *
     * Store the serializer definition service name
     *
     * @param string $serviceName The serializer service name
     *
     * @return self
     */
    public function setSerializerServiceName(string $serviceName) : ProcessBuilderBagInterface;

    /**
     * Get serializer service name
     *
     * Return the defined serializer service name or null if not defined
     *
     * @return string|NULL
     */
    public function getSerializerServiceName() : ?string;
}
