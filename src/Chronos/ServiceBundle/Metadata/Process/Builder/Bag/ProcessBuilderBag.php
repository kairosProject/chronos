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
 * Process builder bag
 *
 * This class is the default implementation of the ProcessBuilderBagInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProcessBuilderBag implements ProcessBuilderBagInterface
{
    /**
     * Process name
     *
     * The current process name
     *
     * @var string
     */
    private $processName;

    /**
     * Dispatcher service name
     *
     * The defined dispatcher service name
     *
     * @var string
     */
    private $dispatcherServiceName;

    /**
     * Serializer service name
     *
     * The defined serializer service name
     *
     * @var string
     */
    private $serializerServiceName;

    /**
     * Construct
     *
     * The default ProcessBuilderBag constructor
     *
     * @param string $processName The current process name
     *
     * @return void
     */
    public function __construct(string $processName)
    {
        $this->setProcessName($processName);
    }

    /**
     * Get process name
     *
     * Return the current process name
     *
     * @return string
     */
    public function getProcessName() : string
    {
        return $this->processName;
    }

    /**
     * Get dispatcher service name
     *
     * Return the defined dispatcher service name or null if not defined
     *
     * @return string|NULL
     */
    public function getDispatcherServiceName() : ?string
    {
        return $this->dispatcherServiceName;
    }

    /**
     * Get serializer service name
     *
     * Return the defined serializer service name or null if not defined
     *
     * @return string|NULL
     */
    public function getSerializerServiceName() : ?string
    {
        return $this->serializerServiceName;
    }

    /**
     * Set process name
     *
     * Set the current process name
     *
     * @param string $name The current process name
     *
     * @return self
     */
    public function setProcessName(string $name) : ProcessBuilderBagInterface
    {
        $this->processName = $name;

        return $this;
    }

    /**
     * Set dispatcher service name
     *
     * Store the dispatcher definition service name
     *
     * @param string $serviceName The dispatcher service definition name
     *
     * @return self
     */
    public function setDispatcherServiceName(string $serviceName) : ProcessBuilderBagInterface
    {
        $this->dispatcherServiceName = $serviceName;

        return $this;
    }

    /**
     * Set serializer service name
     *
     * Store the serializer definition service name
     *
     * @param string $serviceName The serializer service name
     *
     * @return self
     */
    public function setSerializerServiceName(string $serviceName) : ProcessBuilderBagInterface
    {
        $this->serializerServiceName = $serviceName;

        return $this;
    }
}
