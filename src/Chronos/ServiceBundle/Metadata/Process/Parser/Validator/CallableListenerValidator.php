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
 * Callable listener validator
 *
 * This class validate the listener as callback
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class CallableListenerValidator extends AbstractPriorityValidator
{
    /**
     * Is valid
     *
     * This method is used to validate a specific listener element, and return true if it's valid
     *
     * @param array $listener The listener definition
     *
     * @return bool
     */
    public function isValid(array $listener) : bool
    {
        if (count($listener) < 2) {
            return false;
        }

        list($class, $method) = $listener;

        if (class_exists($class) && is_callable([$class, $method])) {
            return $this->validatePriority(array_slice($listener, 2));
        }

        return false;
    }
}
