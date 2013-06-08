<?php

namespace Live\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $tabPromo = array();
        $tabPromo[] = "Ancien";
        $tabPromo[] = "P" . date('Y');
        $tabPromo[] = "P" . date('Y', strtotime('+ 1 year'));
        $tabPromo[] = "P" . date('Y', strtotime('+ 2 year'));
        $tabPromo[] = "P" . date('Y', strtotime('+ 3 year'));
        $tabPromo[] = "P" . date('Y', strtotime('+ 4 year'));
        $tabPromo[] = "P" . date('Y', strtotime('+ 5 year'));

        $builder->add('firstname', 'text',  array("label" => "Prénom :", "required" => false));
        $builder->add('realname', 'text',  array("label" => "Nom :", "required" => false));
        $builder->add('promo', 'choice', array("label" => "Promo :", "required" => false,
                                            'choices' => $tabPromo,
                                            'multiple' => false,
                                            'empty_value' => '- Choisissez une option -',
                                            'empty_data'  => -1
                                            ));
        $builder->remove('plainPassword');
        $builder->remove('username');
    }

    public function getName()
    {
        return 'live_user_profile';
    }
}
