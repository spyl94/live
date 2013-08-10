<?php

namespace Live\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CategoryEditType extends CategoryType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('slug')
            ->add('enabled')
        ;
    }

    public function getName()
    {
        return 'live_blogbundle_categoryedittype';
    }
}
