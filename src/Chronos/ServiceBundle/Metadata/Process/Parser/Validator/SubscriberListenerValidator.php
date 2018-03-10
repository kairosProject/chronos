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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscriber listener validator
 *
 * This class validate the listener as event subscriber
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class SubscriberListenerValidator implements ListenerValidatorInterface
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
        return $this->isValidCount($listener) && $this->isValidSubscriber($listener);
    }

    /**
     * Is valid subscriber
     *
     * Validate the event subscriber hierarchy for the given listener
     *
     * @param array $listener The listener definition
     *
     * @return bool
     */
    private function isValidSubscriber(array $listener) : bool
    {
        return is_string($listener[0]) &&
            class_exists($listener[0]) &&
            is_subclass_of($listener[0], EventSubscriberInterface::class);
    }

    /**
     * Is valid count
     *
     * Validate the definition expected count
     *
     * @param array $listener The listener definition
     *
     * @return bool
     */
    private function isValidCount(array $listener) : bool
    {
        return count($listener) == 1;
    }
}
