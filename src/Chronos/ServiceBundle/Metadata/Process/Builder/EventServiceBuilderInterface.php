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

use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;
use Chronos\ServiceBundle\Metadata\Process\EventMetadataInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Event service builder interface
 *
 * This interface is used to define the base EventServiceBuilder methods
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface EventServiceBuilderInterface
{
    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder            $container   The application container builder
     * @param EventMetadataInterface      $metadata    The dispatcher metadata
     * @param string                      $processName The current process name
     * @param ProcessBuilderBagInterface  $processBag  A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        EventMetadataInterface $metadata,
        string $processName,
        ProcessBuilderBagInterface $processBag
    ) : void;
}
