<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Replacement
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "replacements")
 */
class Replacement extends AbstractEntity
{
    /**
     * @var ReplacementDictionary
     * @ORM\ManyToOne(targetEntity = "CustomerHunt\SystemBundle\Entity\ReplacementDictionary", inversedBy = "replacements")
     * @ORM\JoinColumn(name = "dictionaryid", referencedColumnName = "id")
     */
    protected $dictionary;

    /**
     * @var string
     * @ORM\Column(name = "replacement", type = "text")
     */
    protected $replacement;

    /**
     * @var string
     * @ORM\Column(name = "phrase", type = "text")
     */
    protected $phrase;

    /**
     * @return ReplacementDictionary
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }

    /**
     * @return string
     */
    public function getReplacement()
    {
        return $this->replacement;
    }

    /**
     * @return string
     */
    public function getPhrase()
    {
        return $this->phrase;
    }

    /**
     * @param ReplacementDictionary $dictionary
     * @return $this
     */
    public function setDictionary(ReplacementDictionary $dictionary)
    {
        $this->dictionary = $dictionary;

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
     * @param string $phrase
     * @return $this
     */
    public function setPhrase($phrase)
    {
        $this->phrase = $phrase;

        return $this;
    }
}