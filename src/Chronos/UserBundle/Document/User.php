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
namespace Chronos\UserBundle\Document;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations\MappedSuperclass;
use Doctrine\ODM\MongoDB\Mapping\Annotations\InheritanceType;
use Doctrine\ODM\MongoDB\Mapping\Annotations\DiscriminatorField;
use Doctrine\ODM\MongoDB\Mapping\Annotations\DiscriminatorMap;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceMany;
use Chronos\RoleBundle\Document\Role;

/**
 * User
 *
 * This class is used as parent for the user instances of the Chronos\UserBundlelication. It implement the base
 * UserInterface.
 *
 * @category                             Document
 * @package                              Chronos
 * @author                               matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license                              MIT <https://opensource.org/licenses/MIT>
 * @link                                 http://cscfa.fr
 * @MappedSuperclass()
 * @InheritanceType("SINGLE_COLLECTION")
 * @DiscriminatorField("userType")
 * @DiscriminatorMap(
 *      {
 *          "simple_user"="Chronos\UserBundle\Document\SimpleUser",
 *          "admin_user"="Chronos\UserBundle\Document\Administrator"
 *      }
 * )
 */
abstract class User implements UserInterface
{
    /**
     * Id
     *
     * The current user id
     *
     * @var  string
     * @Id()
     */
    private $id;

    /**
     * Username
     *
     * The user name of the current user
     *
     * @var                  string
     * @Field(type="string")
     */
    private $username;

    /**
     * Password
     *
     * The password of the current user
     *
     * @var                  string
     * @Field(type="string")
     */
    private $password;

    /**
     * Salt
     *
     * The password salt for the current user
     *
     * @var                  string
     * @Field(type="string")
     */
    private $salt;

    /**
     * Roles
     *
     * The set of available roles for the current user
     *
     * @var                                                              ArrayCollection
     * @ReferenceMany(targetDocument="Chronos\RoleBundle\Document\Role")
     */
    private $roles;

    /**
     * Construct
     *
     * The default user constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get id
     *
     * Return the current User id
     *
     * @return string|NULL
     */
    public function getId() : ?string
    {
        return $this->id;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The password
     * @see    UserInterface::getPassword()
     */
    public function getPassword() : ?string
    {
        return $this->password;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return $this
     * @see    UserInterface::eraseCredentials()
     */
    public function eraseCredentials() : User
    {
        $this->password = null;
        $this->salt = null;

        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     * @see    \Symfony\Component\Security\Core\User\UserInterface::getSalt()
     */
    public function getSalt() : ?string
    {
        return $this->salt;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     * @see    \Symfony\Component\Security\Core\User\UserInterface::getRoles()
     */
    public function getRoles() : array
    {
        $roles = [];

        foreach ($this->roles as $role) {
            $roles[] = $role->getLabel();
        }

        return $roles;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string|null The username
     * @see    UserInterface::getUsername()
     */
    public function getUsername() : ?string
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * Set the current user username
     *
     * @param string $username The new username
     *
     * @return $this
     */
    public function setUsername($username) : User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * Set the current user password
     *
     * @param string $password The new password
     *
     * @return $this
     */
    public function setPassword($password) : User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt
     *
     * Set the current user salt
     *
     * @param string $salt The new salt
     *
     * @return $this
     */
    public function setSalt($salt) : User
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set roles
     *
     * Set the current user roles
     *
     * @param ArrayCollection $roles The new ArrayCollection of roles
     *
     * @return $this
     */
    public function setRoles(ArrayCollection $roles) : User
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Add role
     *
     * Add a new role to the collection
     *
     * @param Role $role The new role
     *
     * @return User
     */
    public function addRole(Role $role) : User
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    /**
     * Remove role
     *
     * Remove a role from the collection
     *
     * @param Role $role The role to remove
     *
     * @return User
     */
    public function removeRole(Role $role) : User
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }
}
