<?php

namespace P4\MuseumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use P4\MuseumBundle\Form\TicketownerType;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         ->add('validitydate', DateType::class, array(
                 'attr' => array('min' => (new \DateTime())->format('Y-m-d')),
                 'label' => 'ticket.validitydate',
                 'widget' => 'single_text',
                 'years' => range(date('Y'), date('Y')+1),
                 'months' => range(date('m'), 12),
                 'days' => range(date('d'), 31),
               ))
         ->add('type', ChoiceType::class, array('choices' => array(
                'Demi-journée' =>'Demi-journée',
                'Journée' => 'Journée')))
         ->add('ticketowner', TicketownerType::class, array(
            'label' => 'ticketowner.label'))
         ->add('reduction', CheckboxType::class, array (
            'required' => false,
            'attr' => array('nom' => 'checkbox_reduction',
                            'class' => 'form-check-input'),    
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'P4\MuseumBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'p4_museumbundle_ticket';
    }


}
