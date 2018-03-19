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

/**
 * Class definer interface
 *
 * This interface is used to define the mandatory method to get informations during a class instanciation
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ClassDefinerInterface
{
    /**
     * Get class name
     *
     * Return the class name to instanciate
     *
     * @return string
     */
    public function getClassName() : string;

    /**
     * Get constructor arguments
     *
     * Return the constructor arguments for instanciation
     *
     * @return array
     */
    public function getConstructorArguments() : array;
}
