<?php

namespace Live\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cotisant', 'checkbox', array(
                'label' => 'Cotisant',
                'required' => false
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Live\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'live_userbundle_useradmintype';
    }
}
