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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory;

use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayloadInterface;

/**
 * Handler manager factory interface
 *
 * This interface define the base public methods of the validation manager factories
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface HandlerManagerFactoryInterface
{
    /**
     * Get manager
     *
     * Return a new instance of Validation manager
     *
     * @param ValidationPayloadInterface $payload   The validation payload
     * @param ContainerBuilder           $container The application container
     *
     * @return ValidationManager
     */
    public function getManager(ValidationPayloadInterface $payload, ContainerBuilder $container) : ValidationManager;
}
