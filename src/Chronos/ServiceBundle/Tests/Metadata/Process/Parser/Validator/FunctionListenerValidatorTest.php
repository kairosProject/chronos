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

use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\FunctionListenerValidator;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ListenerValidatorInterface;

/**
 * Function listener validator test
 *
 * This class is used to validate the FunctionListenerValidator class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FunctionListenerValidatorTest extends AbstractPriorityValidatorTest
{
    /**
     * Validation provider
     *
     * Return a set of data to validate the validation
     *
     * @return array
     */
    public function validationProvider()
    {
        return [
            [[static::class, 'testIsValid', 12], [12], false],
            [[static::class, 'testIsValid'], [], false],
            [[static::class], [], false],
            [[], [], false],
            [[12], [], false],
            [['string'], [], false],
            [['is_int', 12], [12], true],
            [['array_map'], [], true],
            [[static::class, 'fakeMethod'], [], false]
        ];
    }

    /**
     * Test isValid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\FunctionListenerValidator::isValid
     * method
     *
     * @param array $inputArguments   The isValid input arguments
     * @param array $priorityArgument The priority validator arguments
     * @param bool  $isValid          The validation expected result
     *
     * @return       void
     * @dataProvider validationProvider
     */
    public function testIsValid(array $inputArguments, array $priorityArgument, bool $isValid)
    {
        $instance = $this->getInstance();

        $priorityValidator = $this->createMock(ListenerValidatorInterface::class);
        $priorityValidator->expects($this->exactly((int)$isValid))
            ->method('isValid')
            ->with($this->identicalTo($priorityArgument))
            ->willReturn($isValid);

        $this->getClassProperty('priorityValidator')->setValue($instance, $priorityValidator);

        if ($isValid) {
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
        return FunctionListenerValidator::class;
    }
}
