<?php

namespace ZPB\Admin\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Role
 *
 * @ORM\Table(name="zpb_admin_roles")
 * @ORM\Entity(repositoryClass="ZPB\Admin\UserBundle\Entity\RoleRepository")
 * @UniqueEntity("name", message="Un role porte déjà ce nom.")
 */
class Role implements RoleInterface
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank(message="Vous devez définir un nom")
     * @Assert\Regex("/^[a-zA-Z]+$/", message="Seules les lettres de l'alphabet sont autorisées.")
     */
    private $name;

    /**
     * @ORM\Column(name="readable_name", type="string", length=255)
     * @Assert\Regex("/^[a-z0-9éèêëàâçûüôöîï'_.!?&$£%@# -]*$/i", message="Ce champs contient des caractères non autorisés.")
     */
    private $readableName;

    /**
     * @ORM\ManyToMany(targetEntity="ZPB\Admin\UserBundle\Entity\AdminUser", mappedBy="roles")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReadableName()
    {
        return ($this->readableName === null) ? $this->name : $this->readableName;
    }

    /**
     * @param mixed $readableName
     * @return Role
     */
    public function setReadableName($readableName)
    {
        $this->readableName = $readableName;
        return $this;
    }



    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole()
    {
        return 'ROLE_' . mb_strtoupper($this->name, 'UTF-8');
    }

    public function __toString()
    {
        return $this->getRole();
    }

    /**
     * Add users
     *
     * @param AdminUser $users
     * @return Role
     */
    public function addUser(AdminUser $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param AdminUser $users
     */
    public function removeUser(AdminUser $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
