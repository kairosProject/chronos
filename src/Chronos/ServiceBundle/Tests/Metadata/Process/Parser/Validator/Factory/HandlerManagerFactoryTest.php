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
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Validator\Factory;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory\HandlerManagerFactory;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayloadInterface;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\CallableListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\FunctionListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\SubscriberListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceConfigurationGuesser;

/**
 * HandlerManagerFactory test
 *
 * This class is used to validate the HandlerManagerFactory class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class HandlerManagerFactoryTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory\HandlerManagerFactory::getManager
     * method
     *
     * @return void
     */
    public function testGetManager()
    {
        $instance = $this->getInstance();

        $payload = $this->createMock(ValidationPayloadInterface::class);
        $container = $this->createMock(ContainerBuilder::class);
        $manager = $instance->getManager($payload, $container);

        $this->assertInstanceOf(ValidationManager::class, $manager);

        $validators = array_map(
            function ($object) {
                return get_class($object);
            },
            $manager->getValidators()
        );

        $instances = [
            CallableListenerValidator::class,
            FunctionListenerValidator::class,
            ServiceListenerValidator::class,
            SubscriberListenerValidator::class,
            ServiceConfigurationGuesser::class
        ];

        foreach ($instances as $expectedInstance) {
            $this->assertContains($expectedInstance, $validators);
        }
    }

    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     */
    protected function getTestedClass() : string
    {
        return HandlerManagerFactory::class;
    }
}
