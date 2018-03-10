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

use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy\ValidationStrategyInterface;

/**
 * Validation manager
 *
 * This class is used to process a set of validation on a listener, and return the strategy result
 * after call with validation process collection
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ValidationManager implements ListenerValidatorInterface
{
    /**
     * Validator
     *
     * Store the listener validator collection
     *
     * @var \SplObjectStorage
     */
    private $validators;

    /**
     * Validation strategy
     *
     * Store the validation strategy
     *
     * @var ValidationStrategyInterface
     */
    private $validationStrategy;

    /**
     * Construct
     *
     * The default ValidationManager constructor
     *
     * @param ValidationStrategyInterface $strategy   The validation strategy
     * @param array                       $validators The set of validators to affect on listeners
     *
     * @return void
     */
    public function __construct(ValidationStrategyInterface $strategy, array $validators = [])
    {
        $this->validationStrategy = $strategy;
        $this->validators = new \SplObjectStorage();

        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
    }

    /**
     * Add validator
     *
     * Add a validator to affect on listener
     *
     * @param ListenerValidatorInterface $validator The validator to add
     *
     * @return $this
     */
    public function addValidator(ListenerValidatorInterface $validator) : ValidationManager
    {
        $this->validators->attach($validator);
        return $this;
    }

    /**
     * Remove validator
     *
     * Remove a validator from the validation list
     *
     * @param ListenerValidatorInterface $validator The validator to remove
     *
     * @return $this
     */
    public function removeValidator(ListenerValidatorInterface $validator) : ValidationManager
    {
        $this->validators->detach($validator);
        return $this;
    }

    /**
     * Get validators
     *
     * Return the validator list
     *
     * @return array
     */
    public function getValidators() : array
    {
        $result = [];
        foreach ($this->validators as $validator) {
            array_push($result, $validator);
        }
        return $result;
    }

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
        $validations = [];
        foreach ($this->validators as $validator) {
            array_push($validations, $validator->isValid($listener));
        }

        return $this->validationStrategy->isValid($validations);
    }
}
