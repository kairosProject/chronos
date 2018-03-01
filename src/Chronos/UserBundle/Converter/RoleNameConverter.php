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
 * @category Converter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\UserBundle\Converter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * Role name converter
 *
 * This class is used to convert the properties name of the user roles elements
 *
 * @category Converter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class RoleNameConverter implements NameConverterInterface
{
    /**
     * Converts a property name to its denormalized value.
     *
     * @param string $propertyName The property name to convert
     *
     * @return string
     */
    public function denormalize($propertyName)
    {
        if ($propertyName == 'roles') {
            return 'roleEntities';
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
        if ($propertyName == 'roleEntities') {
            return 'roles';
        }

        return $propertyName;
    }
}
