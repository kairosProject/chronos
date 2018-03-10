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
 * Priority validator
 *
 * Validate the element slice to be a valid priority or empty
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class PriorityValidator implements ListenerValidatorInterface
{
    /**
     * Is valid
     *
     * This method is used to validate a specific listener element, and return true if it's valid
     *
     * @param array $priority The listener definition
     *
     * @return bool
     */
    public function isValid(array $priority): bool
    {
        if (empty($priority)) {
            return true;
        }

        return count($priority) == 1 && is_int($priority[array_keys($priority)[0]]);
    }
}
