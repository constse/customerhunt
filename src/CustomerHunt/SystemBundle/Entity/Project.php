<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Project
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "projects")
 */
class Project extends AbstractEntity
{
    /**
     * @var string
     * @ORM\Column(name = "caption", type = "string")
     */
    protected $caption;

    /**
     * @var string
     * @ORM\Column(name = "description", type = "text", nullable = true)
     */
    protected $description;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity = "CustomerHunt\SystemBundle\Entity\User", inversedBy = "projects")
     * @ORM\JoinColumn(name = "ownerid", referencedColumnName = "id")
     */
    protected $owner;

    /**
     * @var ArrayCollection|Page[]
     * @ORM\OneToMany(targetEntity = "CustomerHunt\SystemBundle\Entity\Page", mappedBy = "project", cascade = {"persist", "remove"})
     */
    protected $pages;

    /**
     * @var ArrayCollection|TestPage[]
     * @ORM\OneToMany(targetEntity = "CustomerHunt\SystemBundle\Entity\TestPage", mappedBy = "project", cascade = {"persist", "remove"})
     */
    protected $testPages;

    public function __construct()
    {
        parent::__construct();

        $this->pages = new ArrayCollection();
        $this->testPages = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return ArrayCollection|Page[]
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @return ArrayCollection|TestPage[]
     */
    public function getTestPages()
    {
        return $this->testPages;
    }

    /**
     * @param string $caption
     * @return $this
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param User $owner
     * @return $this
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }
}
