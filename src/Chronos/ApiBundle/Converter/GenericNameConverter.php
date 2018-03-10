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
 * @category Converter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Converter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * Generic name converter
 *
 * This class is used to convert the properties name of the output elements
 *
 * @category Converter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class GenericNameConverter implements NameConverterInterface
{
    /**
     * Name mapping
     *
     * The name convertion mapping
     *
     * @var array
     */
    private $nameMapping = [];

    /**
     * Construct
     *
     * The default GenericNameConverter constructor
     *
     * @param array $mapping The name convertion mapping
     *
     * @return void
     */
    public function __construct(array $mapping = [])
    {
        $this->nameMapping = $mapping;
    }

    /**
     * Converts a property name to its denormalized value.
     *
     * @param string $propertyName The property name to convert
     *
     * @return string
     */
    public function denormalize($propertyName)
    {
        if (in_array($propertyName, $this->nameMapping)) {
            return array_search($propertyName, $this->nameMapping);
        }

        return $propertyName;
    }

    /**
     * Converts a property name to its normalized value.
     *
     * @param string $propertyName The property name to convert
     *
     * @return string
     */
    public function normalize($propertyName)
    {
        if (array_key_exists($propertyName, $this->nameMapping)) {
            return $this->nameMapping[$propertyName];
        }

        return $propertyName;
    }
}
