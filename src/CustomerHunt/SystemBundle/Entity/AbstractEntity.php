<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractEntity
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\MappedSuperclass
 */
class AbstractEntity
{
    /**
     * @var \DateTime
     * @ORM\Column(name = "createdat", type = "datetime")
     */
    protected $createdAt;

    /**
     * @var int
     * @ORM\Column(name = "id", type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @ORM\Column(name = "modifiedat", type = "datetime")
     */
    protected $modifiedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->modifiedAt = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->modifiedAt = new \DateTime();
    }
}
