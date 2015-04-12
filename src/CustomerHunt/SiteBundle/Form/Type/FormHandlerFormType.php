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
            ))->add('ajax', 'checkbox', array('label' => 'Обработка с помощью AJAX', 'required' => false))
            ->add('ajaxMessageSuccess', 'textarea', array('label' => 'Сообщение при успешной обработке формы'))
            ->add('ajaxMessageError', 'textarea', array('label' => 'Сообщение при ошибке обработки формы'))
            ->add('redirect', 'url', array('label' => 'URL перенаправления после обработки', 'required' => false))
            ->add('email', 'checkbox', array('label' => 'Отправка электронного письма с результатом обработки'))
            ->add('emailRecipients', 'textarea', array('label' => 'Адреса получателей электронного письма'))
            ->add('emailTemplate', 'textarea', array('label' => 'Шаблон содержимого электронного письма'));
    }
} 