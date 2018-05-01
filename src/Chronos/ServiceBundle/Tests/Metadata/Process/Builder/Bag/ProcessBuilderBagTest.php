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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Builder\Bag;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBag;

/**
 * ProcessBuilderBag test
 *
 * This class is used to validate the ProcessBuilderBag class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProcessBuilderBagTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBag::__construct method
     *
     * @return void
     */
    public function testConstructor() : void
    {
        $this->assertConstructor(
            [
                'processName' => 'name'
            ]
        );

        return;
    }

    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBag processName accessor
     *
     * @return void
     */
    public function testProcessNameAccessor() : void
    {
        $this->assertHasSimpleAccessor('processName', 'name');
        return;
    }

    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBag dispatcherServiceName accessor
     *
     * @return void
     */
    public function testDispatcherServiceNameAccessor() : void
    {
        $this->assertHasSimpleAccessor('dispatcherServiceName', 'service_name');
        return;
    }

    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBag serializerServiceName accessor
     *
     * @return void
     */
    public function testSerializerServiceNameAccessor() : void
    {
        $this->assertHasSimpleAccessor('serializerServiceName', 'service_name');
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
        return ProcessBuilderBag::class;
    }
}
