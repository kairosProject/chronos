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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Validator;

/**
 * Validation payload interface
 *
 * This interface define the base public methods of the ValidationPayload
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ValidationPayloadInterface
{
    /**
     * Set config
     *
     * Set up the actual configuration
     *
     * @param array $config The configuration
     *
     * @return ValidationPayloadInterface
     */
    public function setConfig(array $config) : ValidationPayloadInterface;

    /**
     * Get configuration
     *
     * Return the current configuration
     *
     * @return array
     */
    public function getConfig() : array;
}
