<?php

namespace CustomerHunt\SystemBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class FormHandler
 * @package CustomerHunt\SystemBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name = "formhandlers")
 */
class FormHandler extends AbstractEntity
{
    /**
     * @var string
     * @ORM\Column(name = "caption", type = "string")
     */
    protected $caption;

    /**
     * @var bool
     * @ORM\Column(name = "customeremail", type = "boolean")
     */
    protected $customerEmail;

    /**
     * @var string
     * @ORM\Column(name = "customeremailsubject", type = "string", nullable = true)
     */
    protected $customerEmailSubject;

    /**
     * @var string
     * @ORM\Column(name = "customeremailtemplate", type = "text", nullable = true)
     */
    protected $customerEmailTemplate;

    /**
     * @var string
     * @ORM\Column(name = "description", type = "text", nullable = true)
     */
    protected $description;

    /**
     * @var string
     * @ORM\Column(name = "emailrecipients", type = "text")
     */
    protected $emailRecipients;

    /**
     * @var string
     * @ORM\Column(name = "emailtemplate", type = "text")
     */
    protected $emailTemplate;

    /**
     * @var string
     * @ORM\Column(name = "errorredirect", type = "text")
     */
    protected $errorRedirect;

    /**
     * @var ArrayCollection|FormField[]
     * @ORM\OneToMany(targetEntity = "CustomerHunt\SystemBundle\Entity\FormField", mappedBy = "form", cascade = {"persist", "remove"})
     */
    protected $fields;

    /**
     * @var Page
     * @ORM\ManyToOne(targetEntity = "CustomerHunt\SystemBundle\Entity\Page", inversedBy = "formHandlers")
     * @ORM\JoinColumn(name = "pageid", referencedColumnName = "id")
     */
    protected $page;

    /**
     * @var string
     * @ORM\Column(name = "selector", type = "text")
     */
    protected $selector;

    /**
     * @var string
     * @ORM\Column(name = "successredirect", type = "text")
     */
    protected $successRedirect;

    public function __construct()
    {
        parent::__construct();

        $this->customerEmail = false;
        $this->fields = new ArrayCollection();
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
    public function getCustomerEmailSubject()
    {
        return $this->customerEmailSubject;
    }

    /**
     * @return string
     */
    public function getCustomerEmailTemplate()
    {
        return $this->customerEmailTemplate;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getEmailRecipients()
    {
        return $this->emailRecipients;
    }

    /**
     * @return string
     */
    public function getEmailTemplate()
    {
        return $this->emailTemplate;
    }

    public function getErrorRedirect()
    {
        return $this->errorRedirect;
    }

    /**
     * @return ArrayCollection|FormField[]
     */
    public function getFields()
    {
        return $this->fields;
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
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * @return string
     */
    public function getSuccessRedirect()
    {
        return $this->successRedirect;
    }

    /**
     * @return bool
     */
    public function isCustomerEmail()
    {
        return $this->customerEmail;
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
     * @param bool $customerEmail
     * @return $this
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * @param string $customerEmailSubject
     * @return $this
     */
    public function setCustomerEmailSubject($customerEmailSubject)
    {
        $this->customerEmailSubject = $customerEmailSubject;

        return $this;
    }

    /**
     * @param string $customerTemplate
     * @return $this
     */
    public function setCustomerEmailTemplate($customerTemplate)
    {
        $this->customerEmailTemplate = $customerTemplate;

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
     * @param string $emailRecipients
     * @return $this
     */
    public function setEmailRecipients($emailRecipients)
    {
        $this->emailRecipients = $emailRecipients;

        return $this;
    }

    /**
     * @param string $emailTemplate
     * @return $this
     */
    public function setEmailTemplate($emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;

        return $this;
    }

    /**
     * @param string $errorRedirect
     * @return $this
     */
    public function setErrorRedirect($errorRedirect)
    {
        $this->errorRedirect = $errorRedirect;

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
     * @param string $selector
     * @return $this
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;

        return $this;
    }

    /**
     * @param string $successRedirect
     * @return $this
     */
    public function setSuccessRedirect($successRedirect)
    {
        $this->successRedirect = $successRedirect;

        return $this;
    }
} 