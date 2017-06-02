<?php

namespace CalendarBundle\Form;

use CmsBundle\Form\ImagesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('start', DateTimeType::class , array(
                'minutes' => range(0, 30, 30),
              //  'model_timezone' => 'Europe/Paris'
            ))
            ->add('end', DateTimeType::class , array(
                'minutes' => range(0, 30, 30),
             //   'model_timezone' => 'Europe/Paris'
            ))
            ->add('titre')
            ->add('contenu', TextareaType::class)
            ->add('color')
            ->add('images', ImagesType::class, array(
                'label' => 'Image de l\'évènement'
            ))
            ->add('addHomeActu', CheckboxType::class, array(
                'required' => false
            ))
            ->add('facebookDescription', TextType::class, array(
                'mapped' => false,
                'required' => true
            ))
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
