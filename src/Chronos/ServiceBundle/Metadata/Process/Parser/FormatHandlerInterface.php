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
namespace Chronos\ServiceBundle\Metadata\Process\Parser;

use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayloadInterface;

/**
 * Format handler interface
 *
 * This interface define the base public methods of the FormatHandlers
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface FormatHandlerInterface
{
    /**
     * Handle data
     *
     * Perform the data handling with all configuration with leading 'process' key. As it, a set of data with all
     * leading 'process' key are able to be given for parsing and validation.
     *
     * @param array                      $data    The data to handle
     * @param ValidationPayloadInterface $payload An optional validation payload
     *
     * @return array
     */
    public function handleData(array $data, ValidationPayloadInterface $payload) : array;
}
