<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class TestPageFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('testPage', 'TestPage');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caption', 'text', array('label' => 'Наименование'))
            ->add('alias', 'text', array('label' => 'ЧПУ'))
            ->add('description', 'textarea', array('label' => 'Описание', 'required' => false))
            ->add('source', 'textarea', array('label' => 'Исходный код страницы'));
    }
}