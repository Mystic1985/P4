<?php

namespace P4\MuseumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketownerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'label' => 'ticketowner.firstname',
                'attr' => array('placeholder' => 'ticketowner.firstname.placeholder')))
            ->add('name', TextType::class, array(
                'label' => 'ticketowner.name',
                'attr' => array('placeholder' => 'ticketowner.name.placeholder')))
            ->add('country', CountryType::class, array(
                'placeholder' => 'Sélectionner un pays',
                'label' => 'ticketowner.country'))
            ->add('birthdate', BirthdayType::class, array(
                'attr' => array(
                            'max' => (new \DateTime())->format('Y-m-d'),
                            'min' => (new \DateTime())->sub(new \DateInterval('P100Y'))->format('Y-m-d')),
                'label' => 'ticketowner.birthdate', 
                'widget' => 'single_text',
                'years' => range(1930, 2018),
                'placeholder' => ''));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'P4\MuseumBundle\Entity\Ticketowner'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'p4_museumbundle_ticketowner';
    }


}
