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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Validator;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Service listener validator test
 *
 * This class is used to validate the ServiceListenerValidator class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceListenerValidatorTest extends AbstractTestClass
{
    /**
     * Test isValid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator::isValid
     * method
     *
     * @return void
     */
    public function testConstructor()
    {
        $this->assertConstructor(
            [
                'same:container' => $this->createMock(ContainerBuilder::class),
                'same:callValidator' => $this->createMock(ValidationManager::class)
            ]
        );
    }

    /**
     * Test container
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator::getContainer and
     * Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator::setContainer method
     *
     * @return void
     */
    public function testContainer()
    {
        $this->assertIsSimpleGetter('same:container', 'getContainer', $this->createMock(ContainerBuilder::class));
        $this->assertIsSimpleSetter('same:container', 'setContainer', $this->createMock(ContainerBuilder::class));
    }

    /**
     * Test callValidator
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator::getCallValidator
     * and Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator::setCallValidator method
     *
     * @return void
     */
    public function testCallValidator()
    {
        $this->assertIsSimpleGetter(
            'same:callValidator',
            'getCallValidator',
            $this->createMock(ValidationManager::class)
        );

        $this->assertIsSimpleSetter(
            'same:callValidator',
            'setCallValidator',
            $this->createMock(ValidationManager::class)
        );
    }

    /**
     * Valid provider
     *
     * Return a set of valid data to validate the isValid method
     *
     * @return array
     */
    public function validProvider()
    {
        return [
            [['serviceName', 'method', 64], ['className', 'method', 64], 'serviceName', 'className', true, true],
            [['serviceName', 'method'], ['className', 'method'], 'serviceName', 'className', true, true],
            [['serviceName'], ['subscriber'], 'serviceName', 'subscriber', true, true],
            [['serviceName'], ['subscriber'], 'serviceName', 'subscriber', false, true],
            [['serviceName'], ['subscriber'], 'serviceName', 'subscriber', true, false]
        ];
    }

    /**
     * Test is valid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceListenerValidator::isValid
     * method
     *
     * @param array  $inputArguments   The isValid input arguments
     * @param array  $managerArguments The sub-manager input arguments
     * @param string $serviceName      The service name
     * @param string $className        The corresponding class name
     * @param bool   $isRegistered     Indicate the service registration into the container
     * @param bool   $isValid          Indicate the callable state of the listener
     *
     * @return       void
     * @dataProvider validProvider
     */
    public function testIsValid(
        array $inputArguments,
        array $managerArguments,
        string $serviceName,
        string $className,
        bool $isRegistered,
        bool $isValid
    ) {
        $definition = $this->createMock(Definition::class);
        $definition->expects($this->exactly((int)$isRegistered))
            ->method('getClass')
            ->willReturn($className);

        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->once())
            ->method('hasDefinition')
            ->with($this->equalTo($serviceName))
            ->willReturn($isRegistered);
        $container->expects($this->exactly((int)$isRegistered))
            ->method('getDefinition')
            ->with($this->equalTo($serviceName))
            ->willReturn($definition);

        $manager = $this->createMock(ValidationManager::class);
        $manager->expects($this->exactly((int)$isRegistered))
            ->method('isValid')
            ->with($this->equalTo($managerArguments))
            ->willReturn($isValid);

        $instance = $this->getInstance();

        $this->getClassProperty('container')->setValue($instance, $container);
        $this->getClassProperty('callValidator')->setValue($instance, $manager);

        if ($isRegistered && $isValid) {
            $this->assertTrue($instance->isValid($inputArguments));
            return;
        }

        $this->assertFalse($instance->isValid($inputArguments));
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
        return ServiceListenerValidator::class;
    }
}
