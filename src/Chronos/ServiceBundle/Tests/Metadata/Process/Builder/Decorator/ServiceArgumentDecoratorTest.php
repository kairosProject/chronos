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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Builder\Decorator;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Builder\Decorator\ServiceArgumentDecorator;
use Chronos\ServiceBundle\Metadata\Process\Builder\Validator\ServiceValidatorInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * ServiceArgumentDecorator test
 *
 * This class is used to validate the ServiceArgumentDecorator class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceArgumentDecoratorTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\Decorator\ServiceArgumentDecorator::__construct
     * method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'same:serviceValidator' => $this->createMock(ServiceValidatorInterface::class)
            ]
        );
    }

    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\Decorator\ServiceArgumentDecorator::decorate method
     *
     * @return void
     */
    public function testDecorate()
    {
        $validator = $this->createMock(ServiceValidatorInterface::class);
        $this->getInvocationBuilder($validator, $this->exactly(2), 'isValid')
            ->withConsecutive(
                $this->equalTo('no_service'),
                $this->equalTo('@service')
            )->willReturnOnConsecutiveCalls(
                false,
                true
            );

        $instance = $this->getInstance();
        $this->getClassProperty('serviceValidator')->setValue($instance, $validator);

        $this->assertEquals('no_service', $instance->decorate('no_service'));

        $service = $instance->decorate('@service');
        $this->assertInstanceOf(Reference::class, $service);
        $this->assertEquals('service', $service->__toString());
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
        return ServiceArgumentDecorator::class;
    }
}
