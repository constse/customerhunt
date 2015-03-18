<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('project', 'Project');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caption', 'text', array('label' => 'Наименование'))
            ->add('description', 'textarea', array('label' => 'Описание', 'required' => false));
    }
} 