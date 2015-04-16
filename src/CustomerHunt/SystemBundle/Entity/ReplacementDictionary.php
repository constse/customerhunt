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
     * @ORM\Column(name = "dicparameter", type = "string", nullable = true)
     */
    protected $parameter;

    /**
     * @var string
     * @ORM\Column(name = "replacement", type = "text", nullable = true)
     */
    protected $replacement;

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

    /**
     * @var bool
     * @ORM\Column(name = "withparameter", type = "boolean")
     */
    protected $withParameter;

    public function __construct()
    {
        parent::__construct();

        $this->replacements = new ArrayCollection();
        $this->withParameter = true;
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
     * @return string
     */
    public function getReplacement()
    {
        return $this->replacement;
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
     * @return bool
     */
    public function isWithParameter()
    {
        return $this->withParameter;
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
     * @param string $replacement
     * @return $this
     */
    public function setReplacement($replacement)
    {
        $this->replacement = $replacement;

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

    /**
     * @param bool $withParameter
     * @return $this
     */
    public function setWithParameter($withParameter)
    {
        $this->withParameter = $withParameter;

        return $this;
    }
}