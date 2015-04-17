<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Symfony\Component\Form\FormBuilderInterface;

class UserFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('user', 'User');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text', array('label' => 'Имя пользователя'))
            ->add('password', 'repeated', array('required' => false,
                'type' => 'password',
                'invalid_message' => 'Пароли не совпадают',
                'first_options' => array('label' => 'Пароль'),
                'second_options' => array('label' => 'Повтор пароля')
            ))->add('roles', 'entity', array('label' => 'Роли', 'required' => true,
                'class' => 'CustomerHunt\SystemBundle\Entity\Role',
                'property' => 'caption',
                'multiple' => true,
                'expanded' => true
            ));
    }
} 