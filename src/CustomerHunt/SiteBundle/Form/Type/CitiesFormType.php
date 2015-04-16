<?php

namespace CustomerHunt\SiteBundle\Form\Type;

use CustomerHunt\SystemBundle\Form\Type\AbstractEntityFormType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;

class CitiesFormType extends AbstractEntityFormType
{
    public function __construct()
    {
        parent::__construct('cities', 'Project');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cities', 'entity', array('label' => 'Активные города', 'required' => false,
            'class' => 'CustomerHunt\SystemBundle\Entity\City',
            'property' => 'caption',
            'multiple' => true,
            'expanded' => true,
            'query_builder' => function(EntityRepository $repository) {
                return $repository->createQueryBuilder('c')
                    ->orderBy('c.caption', 'ASC');
            }
        ));
    }
} 