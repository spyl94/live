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
            ->add('title', 'text', array(
                'attr' => array(
                    'class' => 'input-block-level'
                ),
                'label' => 'Titre'
                ))
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'tinymce',
                    'style' => 'height: 400px',
                    'data-theme' => 'advanced'
                ),
                'label' => 'Contenu'
                ))
            ->add('enabled', 'checkbox', array(
                'label' => 'Visible',
                'required' => false
                ))
            ->add('publicationDateStart', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'label' => 'Date de publication'
                ))
            ->add('commentsEnabled', 'checkbox', array(
                'label' => 'Commentaires autorisés',
                'required' => false
                ))
            ->add('categoriesAdded', 'collection', array(
                    'type' => new CategoryType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'required' => false,
                    'label' => false,
                    'options'  => array(
                        'required'  => true,
                        'attr'      => array('class' => 'cat-add')
                                ),
                ))
            ->add('categories', 'entity', array(
                    'class' => 'Live\BlogBundle\Entity\Category',
                    'property' => 'name',
                    'label' => 'Categories',
                    'required' => false,
                    'multiple' => true,
                    'attr'  => array(
                        'class'  => 'span4',
                    ),
                ))
            ->add('tags', 'entity', array(
                    'class' => 'Live\BlogBundle\Entity\Tag',
                    'property' => 'name',
                    'label' => 'Tags',
                    'required' => false,
                    'multiple' => true,
                    'attr'  => array(
                        'class'  => 'span4',
                    ),
                ))
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
