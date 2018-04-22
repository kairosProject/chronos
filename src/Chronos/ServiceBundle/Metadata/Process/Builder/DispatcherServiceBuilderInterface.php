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
namespace Chronos\ServiceBundle\Metadata\Process\Builder;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\DispatcherMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;

/**
 * Dispatcher service builder interface
 *
 * This interface is used to define the base DispatcherServiceBuilders methods
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DispatcherServiceBuilderInterface
{
    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder            $container  The application container builder
     * @param DispatcherMetadataInterface $metadata   The dispatcher metadata
     * @param ProcessBuilderBagInterface  $processBag A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        DispatcherMetadataInterface $metadata,
        ProcessBuilderBagInterface $processBag
    ) : void;
}
