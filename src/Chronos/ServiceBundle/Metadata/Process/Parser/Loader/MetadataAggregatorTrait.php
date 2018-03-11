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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Loader;

/**
 * Metadata aggregator trait
 *
 * This trait is used as helper for metadata aggregator implementation
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait MetadataAggregatorTrait
{
    /**
     * Data
     *
     * The set of aggregated data
     *
     * @var array
     */
    private $data = [];

    /**
     * Add metadata
     *
     * Store a new metadata resolution
     *
     * @param mixed $data The data resolution for metadata
     *
     * @return $this
     */
    public function addMetadata($data) : MetadataAggregatorInterface
    {
        if (!in_array($data, $this->data)) {
            $this->addOrThrow($data);
        }

        return $this;
    }

    /**
     * Add or throw
     *
     * Add an element to the current storage or throw an InvalidArgumentException
     *
     * @param mixed $data The data to add
     *
     * @throws \InvalidArgumentException
     * @return void
     */
    private function addOrThrow($data) : void
    {
        if (!$this->support($data)) {
            throw new \InvalidArgumentException('The given data is not supported by the current loader');
        }

        $this->data[] = $data;
        return;
    }

    /**
     * Support
     *
     * Indicate if the instance support the given metadata
     *
     * @param mixed $data The data to be supported
     *
     * @return bool
     */
    public abstract function support($data) : bool;
}
