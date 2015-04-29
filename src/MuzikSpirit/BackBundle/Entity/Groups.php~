<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Orders
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity
 */
class Groups implements RoleInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=300)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=300, unique=true)
     */
    private $role;

    /**
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="groups")
     */
    private $user;

    /**
     * @return \DateTime
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param \DateTime $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Groups
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Add user
     *
     * @param \Store\BackendBundle\Entity\User $user
     * @return Groups
     */
    public function addUser(\MuzikSpirit\BackBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Store\BackendBundle\Entity\User $user
     */
    public function removeUser(\MuzikSpirit\BackBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }
}
