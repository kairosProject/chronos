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
namespace Chronos\ServiceBundle\Metadata\Process;

/**
 * Controller metadata
 *
 * This class is the default implementation of the ControllerMetadataInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ControllerMetadata implements ControllerMetadataInterface
{
    /**
     * Class
     *
     * The controller class
     *
     * @var string
     */
    private $class;

    /**
     * Arguments
     *
     * The controller arguments
     *
     * @var array
     */
    private $arguments = [];

    /**
     * Construct
     *
     * The ControllerMetadata default constructor
     *
     * @param string $class     The controller class
     * @param array  $arguments The controller arguments
     *
     * @return void
     */
    public function __construct(string $class, array $arguments = [])
    {
        $this->class = $class;
        $this->arguments = $arguments;
    }

    /**
     * Get class
     *
     * Return the controller class
     *
     * @return string
     */
    public function getClass() : string
    {
        return $this->class;
    }

    /**
     * Get arguments
     *
     * Return the controller arguments
     *
     * @return array
     */
    public function getArguments() : array
    {
        return $this->arguments;
    }
}
