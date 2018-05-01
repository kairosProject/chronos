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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\SubscriberListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\AffirmativeStrategy;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\CallableListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\PriorityValidator;

/**
 * Event manager factory
 *
 * This class is used to build a EventBuilder validation's manager
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class EventManagerFactory implements EventManagerFactoryInterface
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
    public function getListenerManager(ContainerBuilder $container) : ValidationManager
    {
        $priorityValidator = new PriorityValidator();
        $callable = new CallableListenerValidator($priorityValidator);

        return new ValidationManager(
            new AffirmativeStrategy(),
            [
                $callable,
                new ServiceListenerValidator($container, $callable)
            ]
        );
    }

    /**
     * Get subscriber manager
     *
     * Return a new instance of Validation manager accordingly with the subscriber validation part
     *
     * @param ContainerBuilder $container The application container
     *
     * @return ValidationManager
     */
    public function getSubscriberManager(ContainerBuilder $container) : ValidationManager
    {
        $subscriber = new SubscriberListenerValidator();

        return new ValidationManager(
            new AffirmativeStrategy(),
            [
                $subscriber,
                new ServiceListenerValidator($container, $subscriber)
            ]
        );
    }
}
