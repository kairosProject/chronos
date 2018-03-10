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
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Metadata\Process;

/**
 * Provider metadata interface
 *
 * This interface is used to reflect the provider configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ProviderMetadataInterface
{
    /**
     * Get factory
     *
     * Return the manager to be used as repository factory
     *
     * @return string
     */
    public function getFactory() : string;

    /**
     * Get entity
     *
     * Return the entity to use when requesting the repository from the factory
     *
     * @return string
     */
    public function getEntity() : string;
}
