<?php

namespace CmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccueilType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('file', 'file', array('label' => 'Image', 'required' => false))
            ->add('contenu')
            ->add('premiertitre')
            ->add('premiercontenu')
            ->add('deuxiemetitre')
            ->add('deuxiemecontenu')
            ->add('troisiemetitre')
            ->add('troisiemecontenu')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CmsBundle\Entity\Accueil'
        ));
    }
}
