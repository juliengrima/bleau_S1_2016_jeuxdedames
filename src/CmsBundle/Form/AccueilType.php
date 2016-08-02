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
            ->add('contenu', 'textarea')
            ->add('premiertitre')
            ->add('premiercontenu', 'textarea')
            ->add('deuxiemetitre' )
            ->add('deuxiemecontenu', 'textarea')
            ->add('troisiemetitre')
            ->add('troisiemecontenu', 'textarea')
            ->add('langue_active')
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
