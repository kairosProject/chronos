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

use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\PriorityValidator;
use Chronos\ApiBundle\Tests\AbstractTestClass;

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
class PriorityValidatorTest extends AbstractTestClass
{
    /**
     * Test isValid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\PriorityValidator::isValid
     * method
     *
     * @return void
     */
    public function testIsValid()
    {
        $instance = $this->getInstance();

        $this->assertTrue($instance->isValid([]));
        $this->assertTrue($instance->isValid([12]));
        $this->assertFalse($instance->isValid([12, 13]));
        $this->assertFalse($instance->isValid(['string']));
        $this->assertFalse($instance->isValid(['is_int', 12]));
        $this->assertFalse($instance->isValid([static::class]));
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
        return PriorityValidator::class;
    }
}
