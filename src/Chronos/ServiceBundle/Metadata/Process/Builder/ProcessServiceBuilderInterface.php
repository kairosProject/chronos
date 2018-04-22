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
use Chronos\ServiceBundle\Metadata\Process\ProcessMetadataInterface;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;

/**
 * Process service builder interface
 *
 * This interface is used to define the base ProcessServiceBuilder methods
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ProcessServiceBuilderInterface
{
    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder           $container  The application container builder
     * @param ProcessMetadataInterface   $metadata   The formatter metadata
     * @param ProcessBuilderBagInterface $processBag A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        ProcessMetadataInterface $metadata,
        ProcessBuilderBagInterface $processBag
    ) : void;
}
