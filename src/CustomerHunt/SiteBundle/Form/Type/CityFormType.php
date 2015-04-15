<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class CityFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('city', 'City');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('caption', 'text', array('label' => 'Название'))
            ->add('latitude', 'number', array('label' => 'Широта', 'precision' => 6))
            ->add('longitude', 'number', array('label' => 'Долгота', 'precision' => 6))
            ->add('genitive', 'text', array('label' => 'Название в родительном падеже'))
            ->add('dative', 'text', array('label' => 'Название в дательном падеже'))
            ->add('accusative', 'text', array('label' => 'Название в винительном падеже'))
            ->add('ablative', 'text', array('label' => 'Название в творительном падеже'))
            ->add('prepositional', 'text', array('label' => 'Название в предложном падеже'));
    }
} 