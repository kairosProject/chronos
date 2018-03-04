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
 * Process metadata interface
 *
 * This interface is used to reflect the process configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ProcessMetadataInterface
{
    /**
     * Get name
     *
     * Return the unique name of the metadata
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Get formatter
     *
     * Return the formatter metadata
     *
     * @return FormatterMetadataInterface
     */
    public function getFormatter() : FormatterMetadataInterface;

    /**
     * Get provider
     *
     * Return the provider metadata
     *
     * @return ProviderMetadataInterface
     */
    public function getProvider() : ProviderMetadataInterface;

    /**
     * Get dispatcher
     *
     * Return the dispatcher metadata
     *
     * @return DispatcherMetadataInterface
     */
    public function getDispatcher() : DispatcherMetadataInterface;

    /**
     * Get controller
     *
     * Return the controller metadata
     *
     * @return ControllerMetadataInterface
     */
    public function getController() : ControllerMetadataInterface;
}
