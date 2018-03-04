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
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Metadata\Process;

/**
 * Process metadata
 *
 * This class is the default implementation of the ProcessMetadataInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProcessMetadata implements ProcessMetadataInterface
{
    /**
     * Name
     *
     * The unique name of the metadata
     *
     * @var string
     */
    protected $name;

    /**
     * Dispatcher
     *
     * The dispatcher part of the metadata
     *
     * @var DispatcherMetadataInterface
     */
    protected $dispatcher;

    /**
     * Provider
     *
     * The provider part of the metadata
     *
     * @var ProviderMetadataInterface
     */
    protected $provider;

    /**
     * Formatter
     *
     * The formatter part of the metadata
     *
     * @var FormatterMetadataInterface
     */
    protected $formatter;

    /**
     * Controller
     *
     * The controller part of the metadata
     *
     * @var ControllerMetadataInterface
     */
    protected $controller;

    /**
     * Construct
     *
     * The default ProcessMetadata constructor
     *
     * @param string                      $name       The unique name of the metadata
     * @param DispatcherMetadataInterface $dispatcher The dispatcher part of the metadata
     * @param ProviderMetadataInterface   $provider   The provider part of the metadata
     * @param FormatterMetadataInterface  $formatter  The formatter part of the metadata
     * @param ControllerMetadataInterface $controller The controller part of the metadata
     *
     * @return void
     */
    public function __construct(
        string $name,
        DispatcherMetadataInterface $dispatcher,
        ProviderMetadataInterface $provider,
        FormatterMetadataInterface $formatter,
        ControllerMetadataInterface $controller
    ) {
        $this->name = $name;
        $this->dispatcher = $dispatcher;
        $this->provider = $provider;
        $this->formatter = $formatter;
        $this->controller = $controller;
    }

    /**
     * Get name
     *
     * Return the unique name of the metadata
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get formatter
     *
     * Return the formatter metadata
     *
     * @return FormatterMetadataInterface
     */
    public function getFormatter() : FormatterMetadataInterface
    {
        return $this->formatter;
    }

    /**
     * Get provider
     *
     * Return the provider metadata
     *
     * @return ProviderMetadataInterface
     */
    public function getProvider() : ProviderMetadataInterface
    {
        return $this->provider;
    }

    /**
     * Get dispatcher
     *
     * Return the dispatcher metadata
     *
     * @return DispatcherMetadataInterface
     */
    public function getDispatcher() : DispatcherMetadataInterface
    {
        return $this->dispatcher;
    }

    /**
     * Get controller
     *
     * Return the controller metadata
     *
     * @return ControllerMetadataInterface
     */
    public function getController() : ControllerMetadataInterface
    {
        return $this->controller;
    }
}
