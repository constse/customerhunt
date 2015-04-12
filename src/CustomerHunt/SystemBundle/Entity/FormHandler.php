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
     * @var bool
     * @ORM\Column(name = "ajax", type = "boolean")
     */
    protected $ajax;

    /**
     * @var string
     * @ORM\Column(name = "ajaxmessageerror", type = "text", nullable = true)
     */
    protected $ajaxMessageError;

    /**
     * @var string
     * @ORM\Column(name = "ajaxmessagesuccess", type = "text", nullable = true)
     */
    protected $ajaxMessageSuccess;

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
     * @var bool
     * @ORM\Column(name = "email", type = "boolean")
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(name = "emailrecipients", type = "text", nullable = true)
     */
    protected $emailRecipients;

    /**
     * @var string
     * @ORM\Column(name = "emailtemplate", type = "text", nullable = true)
     */
    protected $emailTemplate;

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
     * @ORM\Column(name = "redired", type = "text", nullable = true)
     */
    protected $redirect;

    /**
     * @var string
     * @ORM\Column(name = "selector", type = "text")
     */
    protected $selector;

    public function __construct()
    {
        parent::__construct();

        $this->ajax = false;
        $this->email = false;
        $this->fields = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getAjaxMessageError()
    {
        return $this->ajaxMessageError;
    }

    /**
     * @return string
     */
    public function getAjaxMessageSuccess()
    {
        return $this->ajaxMessageSuccess;
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
    public function getRedirect()
    {
        return $this->redirect;
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
    public function isAjax()
    {
        return $this->ajax;
    }

    /**
     * @return bool
     */
    public function isEmail()
    {
        return $this->email;
    }

    /**
     * @param bool $ajax
     * @return $this
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;

        return $this;
    }

    /**
     * @param string $ajaxMessageError
     * @return $this
     */
    public function setAjaxMessageError($ajaxMessageError)
    {
        $this->ajaxMessageError = $ajaxMessageError;

        return $this;
    }

    /**
     * @param string $ajaxMessageSuccess
     * @return $this
     */
    public function setAjaxMessageSuccess($ajaxMessageSuccess)
    {
        $this->ajaxMessageSuccess = $ajaxMessageSuccess;

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
     * @param bool $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

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
     * @param Page $page
     * @return $this
     */
    public function setPage(Page $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param string $redirect
     * @return $this
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;

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