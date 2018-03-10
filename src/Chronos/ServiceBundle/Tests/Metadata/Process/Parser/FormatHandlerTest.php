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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Parser;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Parser\FormatHandler;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Chronos\ServiceBundle\Tests\Metadata\Process\Parser\Misc\EventSubscriber;

/**
 * Format handler test
 *
 * This class is used to validate the FormatHandler class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FormatHandlerTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\FormatHandler::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'same:listenerValidator' => $this->createMock(ValidationManager::class)
            ]
        );
    }

    /**
     * Test handleData
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\FormatHandler::handleData method
     *
     * @return void
     */
    public function testHandleData()
    {
        $instance = $this->getInstance();

        $validationManager = $this->createMock(ValidationManager::class);
        $validationManager->expects($this->exactly(18))
            ->method('isValid')
            ->withConsecutive(
                $this->equalTo([self::class, 'testHandleData', 10]),
                $this->equalTo([self::class, 'testHandleData']),
                $this->equalTo(['my.service', 5]),
                $this->equalTo(['my.function']),
                $this->equalTo(['allways.work.with.service.or.function']),
                $this->equalTo([self::class, 'testHandleData']),
                $this->equalTo([self::class, 'testHandleData', 10]),
                $this->equalTo([self::class, 'testHandleData']),
                $this->equalTo(['my.service', 5]),
                $this->equalTo(['my.function']),
                $this->equalTo('allways.work.with.service.or.function'),
                $this->equalTo([self::class, 'testHandleData']),
                $this->equalTo([self::class, 'testHandleData']),
                $this->equalTo([self::class, 'testHandleData', 10]),
                $this->equalTo([self::class, 'testHandleData']),
                $this->equalTo(['my.service', 5]),
                $this->equalTo(['my.function']),
                $this->equalTo('allways.work.with.service.or.function'),
                $this->equalTo([EventSubscriber::class])
            )->willReturn(false);

        $this->getClassProperty('listenerValidator')->setValue($instance, $validationManager);

        $result = $instance->handleData(include __DIR__.'/FormatInputFixtures.php');
        $expected = include __DIR__.'/FormatOutputFixture.php';

        $this->assertEquals($expected, $result);
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
        return FormatHandler::class;
    }
}
