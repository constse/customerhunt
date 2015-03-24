<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ReplacementDictionary
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "replacementdictionaries")
 */
class ReplacementDictionary extends AbstractEntity
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
     * @var Page
     * @ORM\ManyToOne(targetEntity = "CustomerHunt\SystemBundle\Entity\Page", inversedBy = "replacementDictionaries")
     * @ORM\JoinColumn(name = "pageid", referencedColumnName = "id")
     */
    protected $page;

    /**
     * @var string
     * @ORM\Column(name = "dicparameter", type = "string")
     */
    protected $parameter;

    /**
     * @var ArrayCollection|Replacement[]
     * @ORM\OneToMany(targetEntity = "CustomerHunt\SystemBundle\Entity\Replacement", mappedBy = "dictionary", cascade = {"persist", "remove"})
     */
    protected $replacements;

    /**
     * @var string
     * @ORM\Column(name = "selector", type = "text")
     */
    protected $selector;

    public function __construct()
    {
        parent::__construct();

        $this->replacements = new ArrayCollection();
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
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return string
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * @return ArrayCollection|Replacement[]
     */
    public function getReplacements()
    {
        return $this->replacements;
    }

    /**
     * @return string
     */
    public function getSelector()
    {
        return $this->selector;
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
     * @param Page $page
     * @return $this
     */
    public function setPage(Page $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param string $parameter
     * @return $this
     */
    public function setParameter($parameter)
    {
        $this->parameter = $parameter;

        return $this;
    }

    /**
     * @param string $selector
     * @return $this
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;

        return $this;
    }
}