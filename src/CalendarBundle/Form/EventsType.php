<?php

namespace CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', 'datetime' , array(
                'minutes' => range(0, 30, 30),
              //  'model_timezone' => 'Europe/Paris'
            ))
            ->add('end', 'datetime' , array(
                'minutes' => range(0, 30, 30),
             //   'model_timezone' => 'Europe/Paris'
            ))
            ->add('titre')
            ->add('contenu')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CalendarBundle\Entity\Events'
        ));
    }
}
