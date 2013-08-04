<?php

namespace Live\BlogBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostEditType extends PostType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         parent::buildForm($builder, $options);
         $builder->add('author');
         $builder->remove('contentFormatter');
    }

    public function getName()
    {
        return 'live_blogbundle_postedittype';
    }
}
