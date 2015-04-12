<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class FormFieldFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('formField', 'FormField');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caption', 'text', array('label' => 'Наименование'))
            ->add('name', 'text', array('label' => 'Атрибут NAME'));
    }
} 