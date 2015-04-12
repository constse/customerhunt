<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Page
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "pages")
 */
class Page extends AbstractEntity
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
     * @var ArrayCollection|FormHandler[]
     * @ORM\OneToMany(targetEntity = "CustomerHunt\SystemBundle\Entity\FormHandler", mappedBy = "page", cascade = {"persist", "remove"})
     */
    protected $formHandlers;

    /**
     * @var Project
     * @ORM\ManyToOne(targetEntity = "CustomerHunt\SystemBundle\Entity\Project", inversedBy = "pages")
     * @ORM\JoinColumn(name = "projectid", referencedColumnName = "id")
     */
    protected $project;

    /**
     * @var ArrayCollection|ReplacementDictionary[]
     * @ORM\OneToMany(targetEntity = "CustomerHunt\SystemBundle\Entity\ReplacementDictionary", mappedBy = "page", cascade = {"persist", "remove"})
     */
    protected $replacementDictionaries;

    public function __construct()
    {
        parent::__construct();

        $this->formHandlers = new ArrayCollection();
        $this->replacementDictionaries = new ArrayCollection();
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
     * @return ArrayCollection|FormHandler[]
     */
    public function getFormHandlers()
    {
        return $this->formHandlers;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return ArrayCollection|ReplacementDictionary[]
     */
    public function getReplacementDictionaries()
    {
        return $this->replacementDictionaries;
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
     * @param Project $project
     * @return $this
     */
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }
} 