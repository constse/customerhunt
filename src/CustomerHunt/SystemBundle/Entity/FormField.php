<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FormField
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "formfields")
 */
class FormField extends AbstractEntity
{
    /**
     * @var string
     * @ORM\Column(name = "caption", type = "string")
     */
    protected $caption;

    /**
     * @var FormHandler
     * @ORM\ManyToOne(targetEntity = "CustomerHunt\SystemBundle\Entity\FormHandler", inversedBy = "fields")
     * @ORM\JoinColumn(name = "formid", referencedColumnName = "id")
     */
    protected $form;

    /**
     * @var string
     * @ORM\Column(name = "fieldname", type = "string")
     */
    protected $name;

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return FormHandler
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @param FormHandler $form
     * @return $this
     */
    public function setForm(FormHandler $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
} 