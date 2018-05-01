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
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayload;

/**
 * ValidationPayload test
 *
 * This class is used to validate the ValidationPayload class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ValidationPayloadTest extends AbstractTestClass
{
    /**
     * Test config
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayload accessor methods
     * regarding the config property
     *
     * @return void
     */
    public function testConfig() : void
    {
        $this->assertHasSimpleAccessor('config', ['config']);

        return;
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
        return ValidationPayload::class;
    }
}
