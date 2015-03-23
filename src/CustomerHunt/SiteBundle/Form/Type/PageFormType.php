<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class PageFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('page', 'Page');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caption', 'text', array('label' => 'Наименование'))
            ->add('description', 'textarea', array('label' => 'Описание', 'required' => false));
    }
}