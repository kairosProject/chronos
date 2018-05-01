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

use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Dispatcher class definer
 *
 * This class is the default implementation of the ClassDefinerInterface and can be used to define a EvenetDispatcher
 * class, comming from Symfony\Component\EventDispatcher\EventDispatcher
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DispatcherClassDefiner implements ClassDefinerInterface
{
    /**
     * Get constructor arguments
     *
     * Return the constructor arguments for instanciation
     *
     * @return array
     */
    public function getConstructorArguments() : array
    {
        return [];
    }

    /**
     * Get class name
     *
     * Return the class name to instanciate
     *
     * @return string
     */
    public function getClassName() : string
    {
        return EventDispatcher::class;
    }
}
