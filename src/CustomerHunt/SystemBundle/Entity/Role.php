<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Class Role
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "roles")
 */
class Role extends AbstractEntity implements RoleInterface
{
    const ADMIN = 'ROLE_ADMIN';
    const USER = 'ROLE_USER';

    /**
     * @var string
     * @ORM\Column(name = "role", type = "string", unique = true)
     */
    protected $role;

    /**
     * @var ArrayCollection|User[]
     * @ORM\ManyToMany(targetEntity = "CustomerHunt\SystemBundle\Entity\User", mappedBy = "roles")
     */
    protected $users;

    public function __construct()
    {
        parent::__construct();

        $this->users = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return ArrayCollection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}
