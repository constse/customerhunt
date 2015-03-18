<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('profile', 'User');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', 'repeated', array('required' => false,
                'type' => 'password',
                'invalid_message' => 'Пароли не совпадают',
                'first_options' => array('label' => 'Пароль'),
                'second_options' => array('label' => 'Повтор пароля')
            ));
    }
} 