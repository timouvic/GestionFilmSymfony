<?php

namespace HTM\FilmoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActeurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom','text')
            ->add('prenom','text')
            ->add('datenaissance','birthday',array('format' => 'dd-MM-yyyy'))
            ->add('sexe','choice', array(
                    'choices' => array('H' => 'Homme', 'F' => 'Femme'),'expanded'=>true
                    )
                )
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HTM\FilmoBundle\Entity\Acteur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'htm_filmobundle_acteur';
    }
}
