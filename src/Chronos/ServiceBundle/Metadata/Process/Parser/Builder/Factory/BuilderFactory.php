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

use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProcessMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\DispatcherMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\EventMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ProviderMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\FormatterMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\SerializerMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\ControllerMetadataBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\MetadataBuilderInterface;

/**
 * Builder factory
 *
 * This class is the default BuilderFactoryInterface implementation
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class BuilderFactory implements BuilderFactoryInterface
{
    /**
     * Get builder
     *
     * Return a ProcessMetadataBuilder instance, provided with DispatcherMetadataBuilder, ProviderMetadataBuilder,
     * FormatterMetadataBuilder and ControllerMetadataBuilder
     *
     * @return MetadataBuilderInterface
     */
    public function getBuilder() : MetadataBuilderInterface
    {
        return new ProcessMetadataBuilder(
            new DispatcherMetadataBuilder(
                new EventMetadataBuilder()
            ),
            new ProviderMetadataBuilder(),
            new FormatterMetadataBuilder(
                new SerializerMetadataBuilder()
            ),
            new ControllerMetadataBuilder()
        );
    }
}
