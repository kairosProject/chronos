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
namespace Chronos\UserBundle\Tests\Resources\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * User data test
 *
 * This class is used to validate the user data class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class UserDataTest extends TestCase
{
    /**
     * Test data
     *
     * Validate the user fixture data
     *
     * @return void
     */
    public function testData()
    {
        $internalPath = 'Resources/Fixtures/';
        $path = substr(__DIR__, 0, (strlen(__DIR__) - strlen($internalPath) - strlen('/test')));
        $path .= $internalPath.'user_data.php';

        $data = include $path;

        $this->assertTrue(is_array($data));

        foreach ($data as $value) {
            $this->assertTrue(is_array($value));
            $this->assertArrayHasKey('name', $value);
            $this->assertArrayHasKey('password', $value);
            $this->assertArrayHasKey('salt', $value);
        }
    }
}
