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
namespace Chronos\ServiceBundle\Metadata\Process\Builder\Validator;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Service validator
 *
 * This class is the default implementation of ServiceValidatorInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceValidator implements ServiceValidatorInterface
{
    /**
     * Container
     *
     * The application container
     *
     * @var ContainerBuilder
     */
    private $container;

    /**
     * Construct
     *
     * The default ServiceValidator constructor
     *
     * @param ContainerBuilder $container The application container
     *
     * @return void
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * Is valid
     *
     * Validate the existance of a given service name
     *
     * @param string $serviceName The service name to validate
     *
     * @return bool
     */
    public function isValid(string $serviceName) : bool
    {
        return $this->container->has($serviceName);
    }
}
