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
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceConfigurationGuesser;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayloadInterface;

/**
 * Service configuration guesser test
 *
 * This class is used to validate the ServiceConfigurationGuesser class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ServiceConfigurationGuesserTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceConfigurationGuesser::__construct
     * method
     *
     * @return void
     */
    public function testConstruct() : void
    {
        $this->assertConstructor(
            [
                'same:payload' => $this->createMock(ValidationPayloadInterface::class)
            ]
        );

        return;
    }

    /**
     * Test isValid
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceConfigurationGuesser::isValid
     * method
     *
     * @return void
     */
    public function testIsValid() : void
    {
        $config = [
            'test' => [
                'provider' => [],
                'dispatcher' => []
            ]
        ];
        $payload = $this->createMock(ValidationPayloadInterface::class);
        $this->getInvocationBuilder($payload, $this->any(), 'getConfig')
            ->willReturn($config);

        $instance = $this->getInstance();
        $this->getClassProperty('payload')->setValue($instance, $payload);

        $this->assertTrue($instance->isValid(['test_provider']));
        $this->assertTrue($instance->isValid(['test_dispatcher']));
        $this->assertFalse($instance->isValid(['test_service']));

        return;
    }

    /**
     * Test isValid error
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ServiceConfigurationGuesser::isValid
     * method in case of error
     *
     * @return void
     */
    public function testIsValidError() : void
    {
        $payload = $this->createMock(ValidationPayloadInterface::class);
        $instance = $this->getInstance();
        $this->getClassProperty('payload')->setValue($instance, $payload);

        $this->expectException(\LogicException::class);
        $instance->isValid([]);

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
        return ServiceConfigurationGuesser::class;
    }
}
