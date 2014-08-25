<?php

namespace ZPB\Admin\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use ZPB\Admin\UserBundle\Validator\Constraints as ZPBAssert;

/**
 * AdminUser
 *
 * @ORM\Table(name="zpb_admin_users")
 * @ORM\Entity(repositoryClass="ZPB\Admin\UserBundle\Entity\AdminUserRepository")
 * @UniqueEntity("username", message="Ce nom d'utilisateur est déjà utilisé.")
 * @UniqueEntity("email", message="Cet email est déjà utilisé.")
 * @ORM\HasLifecycleCallbacks()
 */
class AdminUser implements AdvancedUserInterface, Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Ce champs doit être renseigné.")
     * @Assert\Regex("/^[a-zéèêëàâçûüôöîï' -]+$/i", message="Ce champs contient des caractères non autorisés.")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     * @Assert\NotBlank(message="Ce champs doit être renseigné.")
     * @Assert\Regex("/^[a-zéèêëàâçûüôöîï' -]+$/i", message="Ce champs contient des caractères non autorisés.")
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email(checkHost=true, checkMX=true, message="Ce n'est pas une adresse email valide.")
     */
    private $email;

    /**
     * @var string
     * @ZPBAssert\Civility
     * @ORM\Column(name="civilite", type="string", length=40, nullable=false)
     */
    private $civilite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var boolean
     * @ORM\Column(name="is_locked", type="boolean", nullable=false)
     */
    private $isLocked;


    /**
     * @ORM\ManyToMany(targetEntity="ZPB\Admin\UserBundle\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="zpb_admin_users_roles")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank(message="Ce champs doit être renseigné.")
     * @Assert\Regex("/^[a-z0-9éèêëàâçûüôöîï'_.!?&$£%@# -]+$/i", message="Ce champs contient des caractères non autorisés.")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ZPBAssert\PassWord
     */
    private $plainPassword;

    /**
     * @var string
     * @ORM\Column(name="activation_code", type="string", length=255, nullable=true)
     */
    private $activationCode;

    /**
     * @var \dateTime
     * @ORM\Column(name="activated_at", type="datetime", nullable=true)
     */
    private $activatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="register_before", type="datetime", nullable=true)
     */
    private $registerBefore;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->isActive = false;
        $this->isLocked = false;
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->activationCode = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    /**
     * @return array|\Symfony\Component\Security\Core\Role\Role[]
     */
    public function getRoles()
    {
        return $this->getRolesCollection()->toArray();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \dateTime
     */
    public function getActivatedAt()
    {
        return $this->activatedAt;
    }

    /**
     *
     * @param \dateTime $activatedAt
     * @return AdminUser
     */
    public function setActivatedAt($activatedAt)
    {
        $this->activatedAt = $activatedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegisterBefore()
    {
        return $this->registerBefore;
    }

    /**
     * @param mixed $registerBefore
     * @return AdminUser
     */
    public function setRegisterBefore($registerBefore)
    {
        $this->registerBefore = $registerBefore;
        return $this;
    }



    /**
     * @return string
     */
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    /**
     *
     * @param string $activationCode
     * @return AdminUser
     */
    public function setActivationCode($activationCode)
    {
        $this->activationCode = $activationCode;
        return $this;
    }



    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return AdminUser
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return AdminUser
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return AdminUser
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param string $civilite
     * @return AdminUser
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
        return $this;
    }



    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return AdminUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return AdminUser
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsLocked()
    {
        return $this->isLocked;
    }

    /**
     * @param boolean $isLocked
     * @return AdminUser
     */
    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;
        return $this;
    }



    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return AdminUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return AdminUser
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return AdminUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Add roles
     *
     * @param Role $roles
     * @return AdminUser
     */
    public function addRole(Role $roles)
    {
        if(!$this->roles->contains($roles)){
            $this->roles[] = $roles;
        }


        return $this;
    }

    /**
     * Remove roles
     *
     * @param Role $roles
     */
    public function removeRole(Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRolesCollection()
    {
        return $this->roles;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool    true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool    true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return !$this->isLocked;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool    true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool    true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {

        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized);
    }
}
