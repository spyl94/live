<?php

namespace Live\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('contentFormatter')
            ->add('enabled')
            ->add('publicationDateStart')
            ->add('commentsEnabled')
            ->add('categories')
            ->add('tags')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Live\BlogBundle\Entity\Post'
        ));
    }

    public function getName()
    {
        return 'live_blogbundle_posttype';
    }
}

         /*        $builder
            ->add('title')
            ->add('slug')
            ->add('content')
            ->add('contentFormatter')
            ->add('enabled')
            ->add('publicationDateStart')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('commentsEnabled')
            ->add('commentsCount')
            ->add('author')
            ->add('categories')
            ->add('tags')
        ;

        */
