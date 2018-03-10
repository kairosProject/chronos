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
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\AffirmativeStrategy;

/**
 * Affirmative strategy test
 *
 * This class is used to validate the AffirmativeStrategy class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class AffirmativeStrategyTest extends AbstractTestClass
{
    /**
     * Test isValid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\AffirmativeStrategy::isValid
     * method
     *
     * @return void
     */
    public function testIsValid()
    {
        $instance = $this->getInstance();

        $this->assertTrue($instance->isValid([false, true, false]));

        $this->assertFalse($instance->isValid([false, false, false]));
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
        return AffirmativeStrategy::class;
    }
}
