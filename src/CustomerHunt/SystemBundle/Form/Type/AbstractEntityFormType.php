<?php

namespace CustomerHunt\SystemBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractEntityFormType extends AbstractFormType
{
    protected $dataClass;
    protected $name;
    protected $validationGroups;

    public function __construct($name, $entity, $validationGroups = array(), $method = self::METHOD_POST)
    {
        parent::__construct($name, $method);

        $this->dataClass = 'CustomerHunt\SystemBundle\Entity\\' . $entity;
        $this->validationGroups = is_array($validationGroups) ? $validationGroups : array($validationGroups);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass,
            'method' => $this->method,
            'validation_groups' => $this->validationGroups
        ));
    }
}