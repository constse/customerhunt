<?php

namespace CustomerHunt\SystemBundle\Entity;

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
     * @var Project
     * @ORM\ManyToOne(targetEntity = "CustomerHunt\SystemBundle\Entity\Project", inversedBy = "pages")
     * @ORM\JoinColumn(name = "projectid", referencedColumnName = "id")
     */
    protected $project;

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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
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