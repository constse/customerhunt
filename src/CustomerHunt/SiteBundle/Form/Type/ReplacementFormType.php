<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class ReplacementFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('replacement', 'Replacement');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('phrase', 'textarea', array('label' => 'Фраза'))
            ->add('replacement', 'textarea', array('label' => 'Замена'))
            ->add('cityReplacement', 'textarea', array('label' => 'Замена с городом', 'required' => false));
    }
} 