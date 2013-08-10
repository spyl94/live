<?php

namespace Live\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('enabled')
            //->add('slug')
            //->add('createdAt')
            //->add('updatedAt')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Live\BlogBundle\Entity\Tag'
        ));
    }

    public function getName()
    {
        return 'live_blogbundle_tagtype';
    }
}
