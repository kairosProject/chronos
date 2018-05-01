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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Validator;

use Chronos\ServiceBundle\Metadata\Process\Builder\Traits\ServiceNameTrait;

/**
 * Service configuration guesser
 *
 * This class is used as validator for the configuration future services
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceConfigurationGuesser implements ListenerValidatorInterface
{
    use ServiceNameTrait;

    /**
     * Payload
     *
     * The configuration payload
     *
     * @var ValidationPayloadInterface
     */
    private $payload;

    /**
     * Construct
     *
     * The default ServiceConfigurationGuesser constructor
     *
     * @param ValidationPayloadInterface $payload The configuration payload
     *
     * @return void
     */
    public function __construct(ValidationPayloadInterface $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Is valid
     *
     * This method is used to validate a specific listener element, and return true if it's valid
     *
     * @param array $listener The listener definition
     *
     * @return bool
     */
    public function isValid(array $listener) : bool
    {
        $config = $this->payload->getConfig();
        $configKeys = is_array($config) ? array_keys($config) : [];

        if (!isset($configKeys[0])) {
            throw new \LogicException('Configuration must have name');
        }
        $processName = $configKeys[0];

        $allowedServices = [];
        foreach (array_keys($config[$processName]) as $suffix) {
            $this->serviceName = $suffix;
            $allowedServices[] = $this->buildServiceName($processName);
        }

        if (isset($listener[0]) && in_array($listener[0], $allowedServices)) {
            return true;
        }
        return false;
    }
}
