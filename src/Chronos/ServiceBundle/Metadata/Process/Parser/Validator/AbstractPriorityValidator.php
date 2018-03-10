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
 * Abstract priority validator
 *
 * This class is used as priority validation helper
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractPriorityValidator implements ListenerValidatorInterface
{
    /**
     * Priority validator
     *
     * Store the priority validator
     *
     * @var ListenerValidatorInterface
     */
    private $priorityValidator;

    /**
     * Construct
     *
     * The default CallableListenerValidator constructor
     *
     * @param ListenerValidatorInterface $priorityValidator The priority validator
     *
     * @return void
     */
    public function __construct(ListenerValidatorInterface $priorityValidator)
    {
        $this->priorityValidator = $priorityValidator;
    }

    /**
     * Validate priority
     *
     * Facade of priority validator validation
     *
     * @param array $priority The priority to validate
     *
     * @return bool
     */
    protected function validatePriority(array $priority) : bool
    {
        return $this->priorityValidator->isValid($priority);
    }
}
