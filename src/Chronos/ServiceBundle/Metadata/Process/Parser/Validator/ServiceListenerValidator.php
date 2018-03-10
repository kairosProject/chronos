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

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Service listener validator
 *
 * This class is used to validate the usage of a service as validator
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceListenerValidator implements ListenerValidatorInterface
{
    /**
     * Container
     *
     * Store the application container builder
     *
     * @var ContainerBuilder
     */
    private $container;

    /**
     * Call validator
     *
     * The validator used to validate the call of the service, as callback or subscriber
     *
     * @var ValidationManager
     */
    private $callValidator;

    /**
     * Construct
     *
     * The default ServiceListenerValidator constructor
     *
     * @param ContainerBuilder  $container Store the application container builder
     * @param ValidationManager $manager   The validator used to validate the call of the service, as callback or
     *                                     subscriber
     *
     * @return void
     */
    public function __construct(ContainerBuilder $container, ValidationManager $manager)
    {
        $this->container = $container;
        $this->callValidator = $manager;
    }

    /**
     * Get container
     *
     * Return the application container builder currently stored by the validator
     *
     * @return ContainerBuilder
     */
    public function getContainer() : ContainerBuilder
    {
        return $this->container;
    }

    /**
     * Get call validator
     *
     * Return the validator used to validate the call of the service, as callback or subscriber
     *
     * @return ValidationManager
     */
    public function getCallValidator() : ValidationManager
    {
        return $this->callValidator;
    }

    /**
     * Set container
     *
     * Set the application container to validate the service existance
     *
     * @param ContainerBuilder $container The application container
     *
     * @return $this
     */
    public function setContainer(ContainerBuilder $container) : ListenerValidatorInterface
    {
        $this->container = $container;
        return $this;
    }

    /**
     * Set call validator
     *
     * Set the validator to validate the call of the service
     *
     * @param ValidationManager $callValidator The validator set for service call
     *
     * @return $this
     */
    public function setCallValidator(ValidationManager $callValidator) : ListenerValidatorInterface
    {
        $this->callValidator = $callValidator;
        return $this;
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
    public function isValid(array $listener)
    {
        if (isset($listener[0]) && !$this->container->hasDefinition($listener[0])) {
            $class = $this->container->getDefinition($listener[0])->getClass();

            return $this->callValidator->isValid(array_replace($listener, [$class]));
        }

        return false;
    }
}
