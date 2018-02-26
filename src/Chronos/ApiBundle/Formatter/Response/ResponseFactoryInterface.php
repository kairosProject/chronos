<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Formatter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Formatter\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Response factory interface
 *
 * This interface define the main ResponseFactory methods
 *
 * @category Formatter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ResponseFactoryInterface
{
    /**
     * Create response
     *
     * This method create and return a response instance
     *
     * @param array $context The creation context
     *
     * @return Response
     */
    public function createResponse(array $context) : Response;
}

