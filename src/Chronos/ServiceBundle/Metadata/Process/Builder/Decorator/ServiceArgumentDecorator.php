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
namespace Chronos\ServiceBundle\Metadata\Process\Builder\Decorator;

use Chronos\ServiceBundle\Metadata\Process\Builder\Validator\ServiceValidatorInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Service argument decorator
 *
 * This class is the default implementation of ServiceArgumentInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceArgumentDecorator implements ServiceArgumentInterface
{
    /**
     * Service validator
     *
     * The service argument validator
     *
     * @var ServiceValidatorInterface
     */
    private $serviceValidator;

    /**
     * Construct
     *
     * The default ServiceArgumentDecorator construct
     *
     * @param ServiceValidatorInterface $serviceValidator The service argument validator
     *
     * @return void
     */
    public function __construct(ServiceValidatorInterface $serviceValidator)
    {
        $this->serviceValidator = $serviceValidator;
    }

    /**
     * Decorate
     *
     * Decorate a service argument to build the definition
     *
     * @param string $argument The service argument
     *
     * @return mixed
     */
    public function decorate(string $argument)
    {
        if ($this->serviceValidator->isValid($argument)) {
            return new Reference(
                substr($argument, 0, 1) == '@' ? substr($argument, 1) : $argument
            );
        }

        return $argument;
    }
}
