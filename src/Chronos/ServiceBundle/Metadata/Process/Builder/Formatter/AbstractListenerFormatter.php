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
namespace Chronos\ServiceBundle\Metadata\Process\Builder\Formatter;

use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ListenerValidatorInterface;

/**
 * Abstract ListenerFormatter
 *
 * This class is used to define the shared comportment of the ListenerFormatter implementations
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractListenerFormatter implements ListenerFormatterInterface
{
    /**
     * Validator
     *
     * Store the ListenerValidatorInterface in order to validate the listener
     *
     * @var ListenerValidatorInterface
     */
    private $validator;

    /**
     * Construct
     *
     * The default AbstractListenerFormatter constructor
     *
     * @param ListenerValidatorInterface $validator The ListenerValidatorInterface in order to validate the listener
     *
     * @return void
     */
    public function __construct(ListenerValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Format
     *
     * Format and return the given listener
     *
     * @param mixed $listener The listener to format
     *
     * @return mixed
     */
    public function format($listener)
    {
        if ($this->support($listener)) {
            return $this->concreteFormat($listener);
        }

        throw new \InvalidArgumentException('The given listener is unsupported by the formatter');
    }

    /**
     * Support
     *
     * Define if the current formater support the given listener
     *
     * @param mixed $listener The listener to format
     *
     * @return bool
     */
    public function support($listener) : bool
    {
        return $this->validator->isValid($listener);
    }

    /**
     * Concrete format
     *
     * The concrete formating logic
     *
     * @param mixed $listener The listener to format
     *
     * @return mixed
     */
    abstract protected function concreteFormat($listener);
}
