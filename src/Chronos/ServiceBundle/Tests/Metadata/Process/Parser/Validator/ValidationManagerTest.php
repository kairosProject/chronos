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
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\ValidationStrategyInterface;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ListenerValidatorInterface;

/**
 * Validation manager test
 *
 * This class is used to validate the ValidationManagerTest class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ValidationManagerTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $strategy = $this->createMock(ValidationStrategyInterface::class);
        $this->assertConstructor(['same:validationStrategy'=>$strategy]);

        $validators = [
            $this->createMock(ListenerValidatorInterface::class),
            $this->createMock(ListenerValidatorInterface::class),
            $this->createMock(ListenerValidatorInterface::class)
        ];

        $emptyInstance = new ValidationManager($strategy);
        $this->assertInstanceOf(
            \SplObjectStorage::class,
            $this->getClassProperty('validators')->getValue($emptyInstance)
        );

        $instance = new ValidationManager($strategy, $validators);
        $storage = $this->getClassProperty('validators')->getValue($instance);
        foreach ($validators as $validator) {
            $this->assertTrue($storage->contains($validator));
        }
    }

    /**
     * Test addValidator
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager::addValidator method
     *
     * @return void
     */
    public function testAddValidator()
    {
        $storage = new \SplObjectStorage();
        $validator = $this->createMock(ListenerValidatorInterface::class);

        $instance = $this->getInstance();
        $this->getClassProperty('validators')->setValue($instance, $storage);

        $instance->addValidator($validator);

        $this->assertTrue($storage->contains($validator));
    }

    /**
     * Test removeValidator
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager::removeValidator method
     *
     * @return void
     */
    public function testRemoveValidator()
    {
        $storage = new \SplObjectStorage();
        $validator = $this->createMock(ListenerValidatorInterface::class);
        $storage->attach($validator);

        $instance = $this->getInstance();
        $this->getClassProperty('validators')->setValue($instance, $storage);

        $instance->removeValidator($validator);

        $this->assertEquals(0, $storage->count());
    }

    /**
     * Test getValidators
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager::getValidators method
     *
     * @return void
     */
    public function testGetValidators()
    {
        $storage = new \SplObjectStorage();
        $validator1 = $this->createMock(ListenerValidatorInterface::class);
        $validator2 = $this->createMock(ListenerValidatorInterface::class);
        $storage->attach($validator1);
        $storage->attach($validator2);

        $instance = $this->getInstance();
        $this->getClassProperty('validators')->setValue($instance, $storage);

        $this->assertEquals([$validator1, $validator2], $instance->getValidators());
    }

    /**
     * Test isValid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager::isValid method
     *
     * @return void
     */
    public function testIsValid()
    {
        $storage = new \SplObjectStorage();
        $validator = $this->createMock(ListenerValidatorInterface::class);
        $validator->expects($this->once())
            ->method('isValid')
            ->with($this->equalTo(['string']))
            ->willReturn(true);
        $storage->attach($validator);

        $detractor = $this->createMock(ListenerValidatorInterface::class);
        $detractor->expects($this->once())
            ->method('isValid')
            ->with($this->equalTo(['string']))
            ->willReturn(false);
        $storage->attach($detractor);

        $strategy = $this->createMock(ValidationStrategyInterface::class);
        $strategy->expects($this->once())
            ->method('isValid')
            ->with($this->equalTo([true, false]))
            ->willReturn(true);

        $instance = $this->getInstance();
        $this->getClassProperty('validators')->setValue($instance, $storage);
        $this->getClassProperty('validationStrategy')->setValue($instance, $strategy);

        $this->assertTrue($instance->isValid(['string']));
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
        return ValidationManager::class;
    }
}
