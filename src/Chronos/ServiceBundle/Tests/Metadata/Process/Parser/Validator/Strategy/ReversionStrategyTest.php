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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Validator\Strategy;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\ReversionStrategy;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\ValidationStrategyInterface;

/**
 * Reversion strategy test
 *
 * This class is used to validate the ReversionStrategy class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ReversionStrategyTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\ReversionStrategy::__construct
     * method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'same:strategy' => $this->createMock(ValidationStrategyInterface::class)
            ]
        );
    }

    /**
     * Test isValid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\ReversionStrategy::isValid
     * method
     *
     * @return void
     */
    public function testIsValid()
    {
        $subject = [new \stdClass()];

        $validStrategy = $this->createMock(ValidationStrategyInterface::class);
        $validStrategy->expects($this->once())
            ->method('isValid')
            ->with($this->identicalTo($subject))
            ->willReturn(true);

        $unvalidStrategy = $this->createMock(ValidationStrategyInterface::class);
        $unvalidStrategy->expects($this->once())
            ->method('isValid')
            ->with($this->identicalTo($subject))
            ->willReturn(false);

        $property = $this->getClassProperty('strategy');

        $validInstance = $this->getInstance();
        $property->setValue($validInstance, $validStrategy);
        $this->assertFalse($validInstance->isValid($subject));

        $unvalidInstance = $this->getInstance();
        $property->setValue($unvalidInstance, $unvalidStrategy);
        $this->assertTrue($unvalidInstance->isValid($subject));
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
        return ReversionStrategy::class;
    }
}
