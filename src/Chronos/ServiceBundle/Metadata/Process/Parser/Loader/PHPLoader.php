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
 * PHP loader
 *
 * This class is used as metadata loader for native PHP array
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class PHPLoader implements MetadataLoaderInterface, MetadataAggregatorInterface, MetadataSupportInterface
{
    use MetadataAggregatorTrait;

    /**
     * Load
     *
     * Load the data from source data
     *
     * @param mixed|null $data The source data
     *
     * @return array
     */
    public function load($data = null) : array
    {
        if ($data) {
            $this->addMetadata($data);
        }

        $result = [];
        foreach ($this->data as $element) {
            $result[] = $element['process'];
        }

        return $result;
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
    public function support($data) : bool
    {
        return is_array($data) && array_key_exists('process', $data);
    }
}
