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
            ->add('selector', 'text', array('label' => 'CSS-селектор элемента замены'))
            ->add('withParameter', 'checkbox', array('label' => 'Использовать GET-параметр', 'required' => false))
            ->add('replacement', 'textarea', array('label' => 'Замена с городом', 'required' => false))
            ->add('parameter', 'text', array('label' => 'GET-параметр', 'required' => false));
    }
} 