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
 * Controller metadata interface
 *
 * This interface is used to reflect the controller configuration
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ControllerMetadataInterface
{
    /**
     * Get class
     *
     * Return the controller class
     *
     * @return string
     */
    public function getClass() : string;

    /**
     * Get arguments
     *
     * Return the controller arguments
     *
     * @return array
     */
    public function getArguments() : array;
}
