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
namespace Chronos\ServiceBundle\Metadata\Process\Parser;

use Chronos\ServiceBundle\Metadata\Process\ProcessMetadataInterface;

/**
 * Process metadata parser interface
 *
 * This interface is used to define the base methods of the metadata parser
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ProcessMetadataParserInterface
{
    /**
     * Parse
     *
     * Parse the given data and convert to ProcessMetadataInterface
     *
     * @param mixed $data The data to parse
     *
     * @return ProcessMetadataInterface
     */
    public function parse($data) : ProcessMetadataInterface;

    /**
     * Support
     *
     * Validate that the current parser support the given data
     *
     * @param mixed $data The data to inspect
     *
     * @return bool
     */
    public function support($data) : bool;
}
