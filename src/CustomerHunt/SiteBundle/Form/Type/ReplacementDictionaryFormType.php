<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class ReplacementDictionaryFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('dictionary', 'ReplacementDictionary');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caption', 'text', array('label' => 'Наименование'))
            ->add('description', 'textarea', array('label' => 'Описание', 'required' => false))
            ->add('parameter', 'text', array('label' => 'GET-параметр'))
            ->add('selector', 'text', array('label' => 'CSS-селектор элемента замены'));
    }
} 