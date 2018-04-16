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
namespace Chronos\ServiceBundle\Tests\Metadata\Process\Builder;

use Chronos\ApiBundle\Tests\AbstractTestClass;
use Chronos\ServiceBundle\Metadata\Process\Builder\EventServiceBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ListenerValidatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\EventMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Symfony\Component\DependencyInjection\Definition;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * EventServiceBuilder test
 *
 * This class is used to validate the EventServiceBuilder class
 *
 * @category Test
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class EventServiceBuilderTest extends AbstractTestClass
{
    /**
     * Test construct
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\EventServiceBuilder::__construct method
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'same:listenerValidator' => $this->createMock(ListenerValidatorInterface::class)
            ]
        );
    }

    /**
     * Listeners provider
     *
     * Return a set of listeners in order to validate the EventServiceBuilder::buildProcessServices method
     *
     * @return array
     */
    public function listenersProvider()
    {
        return [
            [[]],
            [[['function']]],
            [[['function', 10]]],
            [[['subscriber']]],
            [[['function1'], ['function2']]]
        ];
    }

    /**
     * Test buildProcessServices fail
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\EventServiceBuilder::buildProcessServices method in
     * case of exception
     *
     * @return void
     */
    public function testBuildProcessServicesFail()
    {
        $instance = $this->getInstance();

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(EventMetadataInterface::class);
        $processBag = $this->createMock(ProcessBuilderBagInterface::class);

        $processBag->expects($this->once())
            ->method('getDispatcherServiceName')
            ->willReturn('dispatcher_service');

        $container->expects($this->once())
            ->method('hasDefinition')
            ->with($this->equalTo('dispatcher_service'))
            ->willReturn(false);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessageRegExp('/dispatcher_service must be defined/');

        $instance->buildProcessServices(
            $container,
            $metadata,
            $processBag
        );
    }

    /**
     * Test buildProcessServices
     *
     * Validate the Chronos\ServiceBundle\Metadata\Process\Builder\EventServiceBuilder::buildProcessServices method
     *
     * @param array $listeners The current listeners to be validated
     *
     * @return       void
     * @dataProvider listenersProvider
     */
    public function testBuildProcessServices(array $listeners)
    {
        $instance = $this->getInstance();

        $listenerValidator = $this->createMock(ListenerValidatorInterface::class);

        $this->getClassProperty('listenerValidator')->setValue($instance, $listenerValidator);

        $container = $this->createMock(ContainerBuilder::class);
        $metadata = $this->createMock(EventMetadataInterface::class);
        $processBag = $this->createMock(ProcessBuilderBagInterface::class);
        $dispatcherDefinition = $this->createMock(Definition::class);

        $processBag->expects($this->once())
            ->method('getDispatcherServiceName')
            ->willReturn('dispatcher_service');

        $container->expects($this->once())
            ->method('hasDefinition')
            ->with($this->equalTo('dispatcher_service'))
            ->willReturn(true);

        $container->expects($this->once())
            ->method('getDefinition')
            ->with($this->equalTo('dispatcher_service'))
            ->willReturn($dispatcherDefinition);

        $metadata->expects($this->once())
            ->method('getListeners')
            ->willReturn($listeners);

        $this->configureMocks($listeners, $metadata, $listenerValidator, $dispatcherDefinition);

        $instance->buildProcessServices(
            $container,
            $metadata,
            $processBag
        );
    }

    /**
     * Set metadata event call
     *
     * This method set the getEvent method call for the metadata mock object
     *
     * @param MockObject $metadata   The base metadata
     * @param array      $listeners  The listener list to build the dispatcher
     * @param bool       $isListener Define if the current listener is a subscriber or a listener
     *
     * @return void
     */
    public function setMetadataEventCall(MockObject $metadata, array $listeners, bool $isListener) : void
    {
        if ($isListener) {
            $metadata->expects($this->exactly(count($listeners)))
                ->method('getEvent')
                ->willReturn('metadata_event');

            return;
        }
        $metadata->expects($this->never())
            ->method('getEvent');
    }

    /**
     * Set method call
     *
     * This method set the dispatcher methods call for the dispatcher definition.
     *
     * @param array $validatorArgs  The current validator arguments
     * @param array $listener       The listener list to build the dispatcher
     * @param bool  $isListener     Define if the current listener is a subscriber or a listener
     * @param array $dispatcherArgs The current dispatcher arguments
     *
     * @return void
     */
    public function setMethodCall(
        array $validatorArgs,
        array $listener,
        bool $isListener,
        array &$dispatcherArgs
    ) : void {
        $validatorArgs[] = $this->equalTo($listener);

        $priority = 0;
        if (is_numeric($listener[(count($listener) - 1)])) {
            $priority = array_pop($listener);
        }

        if ($isListener) {
            $dispatcherArgs[] = [
                $this->equalTo('addListener'),
                $this->equalTo(
                    [
                        'metadata_event',
                        $listener,
                        $priority
                    ]
                )
            ];

            return;
        }

        $dispatcherArgs[] = [
            $this->equalTo('addSubscriber'),
            $this->equalTo(
                [
                    $listener
                ]
            )
        ];
    }

    /**
     * Configure mocks
     *
     * This method configure the tested mocks regarding the listeners definition
     *
     * @param array      $listeners         The listener list to build the dispatcher
     * @param MockObject $metadata          The base metadata
     * @param MockObject $listenerValidator The listener validator mock object
     * @param MockObject $dispatcher        The dispatcher to load
     *
     * @return void
     */
    public function configureMocks(
        array $listeners,
        MockObject $metadata,
        MockObject $listenerValidator,
        MockObject $dispatcher
    ) : void {
        if (empty($listeners)) {
            return;
        }

        $validatorArgs = [];
        foreach ($listeners as $listener) {
            $validatorArgs[] = $this->equalTo($listener);
        }

        $validity = true;
        if ($listeners[0][0] == 'subscriber') {
            $validity = false;
        }

        $listenerValidator->expects($this->exactly(count($listeners)))
            ->method('isValid')
            ->withConsecutive(...$validatorArgs)
            ->willReturn($validity);

        $this->setMetadataEventCall($metadata, $listeners, $validity);

        $dispatcherArgs = [];
        foreach ($listeners as $listener) {
            $this->setMethodCall($validatorArgs, $listener, $validity, $dispatcherArgs);
        }

        $dispatcher->expects($this->exactly(count($dispatcherArgs)))
            ->method('addMethodCall')
            ->withConsecutive(...$dispatcherArgs);
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
        return EventServiceBuilder::class;
    }
}
