<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "users")
 */
class User extends AbstractEntity implements UserInterface, \Serializable
{
    /**
     * @var string
     * @ORM\Column(name = "code", type = "string")
     */
    protected $code;

    /**
     * @var string
     * @ORM\Column(name = "password", type = "string")
     */
    protected $password;

    /**
     * @var ArrayCollection|Project[]
     * @ORM\OneToMany(targetEntity = "CustomerHunt\SystemBundle\Entity\Project", mappedBy = "owner", cascade = {"remove"})
     */
    protected $projects;

    /**
     * @var ArrayCollection|Role[]
     * @ORM\ManyToMany(targetEntity = "CustomerHunt\SystemBundle\Entity\Role", inversedBy = "users")
     * @ORM\JoinTable(name = "user_roles",
     *   joinColumns = {@ORM\JoinColumn(name = "userid", referencedColumnName = "id")},
     *   inverseJoinColumns = {@ORM\JoinColumn(name = "roleid", referencedColumnName = "id")}
     * )
     */
    protected $roles;

    /**
     * @var string
     * @ORM\Column(name = "salt", type = "string")
     */
    protected $salt;

    /**
     * @var string
     * @ORM\Column(name = "username", type = "string", unique = true)
     */
    protected $username;

    public function __construct()
    {
        parent::__construct();

        $this->code = self::generateCode();
        $this->projects = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->salt = self::generateSalt();
    }

    public function eraseCredentials()
    {
        return $this;
    }

    public static function generateCode()
    {
        $symbols = '0123456789abcdef';
        $code = '';

        foreach (range(1, 16) as $i) $code .= $symbols[mt_rand(0, 15)];

        return $code;
//        return openssl_random_pseudo_bytes(32);
    }

    /**
     * @return string
     */
    public static function generateSalt()
    {
        $symbols = '0123456789abcdef';
        $salt = '';

        foreach (range(1, 32) as $i) $salt .= $symbols[mt_rand(0, 15)];

        return $salt;
//        return openssl_random_pseudo_bytes(32);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return ArrayCollection|Project[]
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @return array|Role[]
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * @return ArrayCollection|Role[]
     */
    public function getRolesCollection()
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function serialize()
    {
        return serialize(array(
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'salt' => $this->salt
        ));
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $salt
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function unserialize($serialized)
    {
        $unserialized = unserialize($serialized);
        $this->id = $unserialized['id'];
        $this->username = $unserialized['username'];
        $this->password = $unserialized['password'];
        $this->salt = $unserialized['salt'];

        return $this;
    }
}
