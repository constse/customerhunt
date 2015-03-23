<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TestPage
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "testpages")
 */
class TestPage extends AbstractEntity
{
    /**
     * @var string
     * @ORM\Column(name = "alias", type = "string")
     */
    protected $alias;

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
     * @ORM\ManyToOne(targetEntity = "CustomerHunt\SystemBundle\Entity\Project", inversedBy = "testPages")
     * @ORM\JoinColumn(name = "projectid", referencedColumnName = "id")
     */
    protected $project;

    /**
     * @var string
     * @ORM\Column(name = "source", type = "text")
     */
    protected $source;

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
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

    /**
     * @param string $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }
}