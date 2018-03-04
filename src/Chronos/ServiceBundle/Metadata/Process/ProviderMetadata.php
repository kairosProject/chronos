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
 * Provider metadata
 *
 * This class is the default implementation of the ProviderMetadataInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProviderMetadata implements ProviderMetadataInterface
{
    /**
     * Factory
     *
     * The manager to be used as repository factory
     *
     * @var string
     */
    private $factory;

    /**
     * Entity
     *
     * The entity to use when requesting the repository from the factory
     *
     * @var string
     */
    private $entity;

    /**
     * Construct
     *
     * The default ProviderMetadata constructor
     *
     * @param string $factory The manager to be used as repository factory
     * @param string $entity  The entity to use when requesting the repository from the factory
     *
     * @return void
     */
    public function __construct(string $factory, string $entity)
    {
        $this->factory = $factory;
        $this->entity = $entity;
    }

    /**
     * Get factory
     *
     * Return the manager to be used as repository factory
     *
     * @return string
     */
    public function getFactory() : string
    {
        return $this->factory;
    }

    /**
     * Get entity
     *
     * Return the entity to use when requesting the repository from the factory
     *
     * @return string
     */
    public function getEntity() : string
    {
        return $this->entity;
    }
}
