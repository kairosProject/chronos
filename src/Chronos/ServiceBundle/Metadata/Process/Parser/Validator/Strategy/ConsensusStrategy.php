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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Strategy;

/**
 * Consensus strategy
 *
 * This class is used as strategy for validate if there are more successful validation than there are failures
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ConsensusStrategy implements ValidationStrategyInterface
{
    /**
     * Is valid
     *
     * This method is used to validate a validation result list
     *
     * @param array $validationResults The validation list
     *
     * @return bool
     */
    public function isValid(array $validationResults)
    {
        $results = array_count_values(array_map('intval', $validationResults));
        return $results[1] > $results[0];
    }
}
