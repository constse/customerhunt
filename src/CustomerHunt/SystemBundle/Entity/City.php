<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class City
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "cities")
 */
class City extends AbstractEntity
{
    /**
     * @var string
     * @ORM\Column(name = "ablative", type = "string")
     */
    protected $ablative;

    /**
     * @var string
     * @ORM\Column(name = "accusative", type = "string")
     */
    protected $accusative;

    /**
     * @var string
     * @ORM\Column(name = "caption", type = "string")
     */
    protected $caption;

    /**
     * @var string
     * @ORM\Column(name = "dative", type = "string")
     */
    protected $dative;

    /**
     * @var string
     * @ORM\Column(name = "genitive", type = "string")
     */
    protected $genitive;

    /**
     * @var float
     * @ORM\Column(name = "latitude", type = "float")
     */
    protected $latitude;

    /**
     * @var float
     * @ORM\Column(name = "longitude", type = "float")
     */
    protected $longitude;

    /**
     * @var string
     * @ORM\Column(name = "prepositional", type = "string")
     */
    protected $prepositional;

    /**
     * @return string
     */
    public function getAblative()
    {
        return $this->ablative;
    }

    /**
     * @return string
     */
    public function getAccusative()
    {
        return $this->accusative;
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
    public function getDative()
    {
        return $this->dative;
    }

    /**
     * @return string
     */
    public function getGenitive()
    {
        return $this->genitive;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function getPrepositional()
    {
        return $this->prepositional;
    }

    /**
     * @param string $ablative
     * @return $this
     */
    public function setAblative($ablative)
    {
        $this->ablative = $ablative;

        return $this;
    }

    /**
     * @param string $accusative
     * @return $this
     */
    public function setAccusative($accusative)
    {
        $this->accusative = $accusative;

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
     * @param string $dative
     * @return $this
     */
    public function setDative($dative)
    {
        $this->dative = $dative;

        return $this;
    }

    /**
     * @param string $genitive
     * @return $this
     */
    public function setGenitive($genitive)
    {
        $this->genitive = $genitive;

        return $this;
    }

    /**
     * @param float $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @param float $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @param string $prepositional
     * @return $this
     */
    public function setPrepositional($prepositional)
    {
        $this->prepositional = $prepositional;

        return $this;
    }
} 