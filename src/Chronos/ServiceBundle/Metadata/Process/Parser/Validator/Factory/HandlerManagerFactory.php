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

use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\AffirmativeStrategy;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\SubscriberListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceConfigurationGuesser;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayloadInterface;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\ReversionStrategy;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\FunctionListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\CallableListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\PriorityValidator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Handler manager factory
 *
 * This class is used to build a FormatHandler validation's manager
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class HandlerManagerFactory implements HandlerManagerFactoryInterface
{
    /**
     * Get manager
     *
     * Return a new instance of Validation manager
     *
     * @param ValidationPayloadInterface $payload   The validation payload
     * @param ContainerBuilder           $container The application container
     *
     * @return ValidationManager
     */
    public function getManager(ValidationPayloadInterface $payload, ContainerBuilder $container) : ValidationManager
    {
        $priorityValidator = new PriorityValidator();
        $strategy = new AffirmativeStrategy();
        $callable = new CallableListenerValidator($priorityValidator);
        $subscriber = new SubscriberListenerValidator();

        return new ValidationManager(
            new ReversionStrategy($strategy),
            [
                $callable,
                new FunctionListenerValidator($priorityValidator),
                new ServiceListenerValidator(
                    $container,
                    new ValidationManager(
                        $strategy,
                        [
                            $callable,
                            $subscriber
                        ]
                    )
                ),
                $subscriber,
                new ServiceConfigurationGuesser($payload)
            ]
        );
    }
}
