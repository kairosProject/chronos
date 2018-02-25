<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace App\Tests\Documents;

use App\Document\SimpleUser;

/**
 * SimpleUser test
 *
 * This class is used to validate the SimpleUser implementation.
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SimpleUserTest extends AbstractTestUser
{
    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     * @see    \App\Tests\AbstractTestClass::getTestedClass()
     */
    protected function getTestedClass() : string
    {
        return SimpleUser::class;
    }
}
