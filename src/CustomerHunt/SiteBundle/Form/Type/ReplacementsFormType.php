<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class ReplacementsFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('replacements', 'ReplacementDictionary');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('replacements', 'collection', array('label' => 'Замены', 'required' => false,
            'type' => new ReplacementFormType(),
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true
        ));
    }
} 