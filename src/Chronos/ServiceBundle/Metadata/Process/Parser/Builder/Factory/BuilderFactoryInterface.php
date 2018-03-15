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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Builder\Factory;

use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\MetadataBuilderInterface;

/**
 * Builder factory interface
 *
 * This interface is used to define the base BuilderFactory methods
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface BuilderFactoryInterface
{
    /**
     * Get builder
     *
     * Return a ProcessMetadata builder instance
     *
     * @return MetadataBuilderInterface
     */
    public function getBuilder() : MetadataBuilderInterface;
}
