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
 * @category Document
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;

/**
 * Role
 *
 * This class is used to store and retreive the user roles.
 *
 * @category Document
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 * @Document
 */
class Role
{
    /**
     * Id
     *
     * The role Id
     *
     * @var string
     * @Id
     */
    private $id;

    /**
     * Label
     *
     * The role label
     *
     * @var                  string
     * @Field(type="string")
     */
    private $label;

    /**
     * Get id
     *
     * Return the current role id
     *
     * @return string|null
     */
    public function getId() : ?string
    {
        return $this->id;
    }

    /**
     * Get label
     *
     * Return the current role label
     *
     * @return string|null
     */
    public function getLabel() : ?string
    {
        return $this->label;
    }

    /**
     * Set label
     *
     * Set the current role label
     *
     * @param string $label The new label
     *
     * @return $this
     */
    public function setLabel($label) : Role
    {
        $this->label = $label;

        return $this;
    }
}
