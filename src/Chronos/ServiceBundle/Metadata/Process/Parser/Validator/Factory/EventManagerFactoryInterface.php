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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory;

use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Event manager factory interface
 *
 * This interface define the base public methods of the event manager factory
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface EventManagerFactoryInterface
{
    /**
     * Get listener manager
     *
     * Return a new instance of Validation manager accordingly with the listener validation part
     *
     * @param ContainerBuilder $container The application container
     *
     * @return ValidationManager
     */
    public function getListenerManager(ContainerBuilder $container) : ValidationManager;

    /**
     * Get subscriber manager
     *
     * Return a new instance of Validation manager accordingly with the subscriber validation part
     *
     * @param ContainerBuilder $container The application container
     *
     * @return ValidationManager
     */
    public function getSubscriberManager(ContainerBuilder $container) : ValidationManager;
}
