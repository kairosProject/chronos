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
namespace Chronos\ServiceBundle\Metadata\Process\Builder\Validator;

/**
 * Service validator interface
 *
 * This interface is used to define the base ServiceValidator methods
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ServiceValidatorInterface
{
    /**
     * Is valid
     *
     * Validate the existance of a given service name
     *
     * @param string $serviceName The service name to validate
     *
     * @return bool
     */
    public function isValid(string $serviceName) : bool;
}
