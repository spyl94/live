<?php

namespace Live\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
            ->add('email')
            ->add('content')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('status')
            ->add('post')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Live\BlogBundle\Entity\Comment'
        ));
    }

    public function getName()
    {
        return 'live_blogbundle_commenttype';
    }
}
