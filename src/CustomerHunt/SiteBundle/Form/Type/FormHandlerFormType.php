<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class FormHandlerFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('formHandler', 'FormHandler');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caption', 'text', array('label' => 'Наименование'))
            ->add('description', 'textarea', array('label' => 'Описание', 'required' => false))
            ->add('selector', 'text', array('label' => 'CSS-селектор'))
            ->add('fields', 'collection', array('label' => 'Параметры формы',
                'type' => new FormFieldFormType(),
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true
            ))->add('successRedirect', 'url', array('label' => 'URL для переадресации при успешной обработке'))
            ->add('errorRedirect', 'url', array('label' => 'URL для переадресации при ошибке обработки'))
            ->add('emailFrom', 'email', array('label' => 'Адрес электронной почты отправителя'))
            ->add('emailRecipients', 'textarea', array('label' => 'Адреса электронной почты получателей уведомления'))
            ->add('emailTemplate', 'textarea', array('label' => 'Шаблон уведомления (HTML)'))
            ->add('customerEmail', 'checkbox', array('label' => 'Отправлять уведомление клиенту', 'required' => false))
            ->add('customerEmailSubject', 'text', array('label' => 'Тема уведомления клиенту', 'required' => false))
            ->add('customerEmailTemplate', 'textarea', array('label' => 'Шаблон уведомления (HTML) для клиента', 'required' => false));
    }
} 