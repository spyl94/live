<?php

namespace Live\LessonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class LessonAskType extends AbstractType
{
    public $id;

    public function __construct($id)
    {
        $this->id= $id;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->id;

        $builder
            ->add('instrument', 'entity', array(
                    'class' => 'LiveLessonBundle:Instrument',
                    'required' => true,
                    'query_builder' => function(EntityRepository $er) use ($id) {
                        return $er->getInstrumentsNotAskedBy($id);
                    }
                ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Live\LessonBundle\Entity\LessonAsk'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'live_lessonbundle_lessonasktype';
    }
}
