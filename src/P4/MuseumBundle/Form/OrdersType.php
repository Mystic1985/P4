<?php

namespace P4\MuseumBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use P4\MuseumBundle\Form\CustomerType;
use P4\MuseumBundle\Form\TicketType;

class OrdersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tickets', CollectionType::class, array(
                'entry_type' => TicketType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
                ))
            ->add('customer', CustomerType::class)
            ->add('numberoftickets', IntegerType::class, array('attr' => array(
                'min' => 1,
                'max' => 100)))
            ->add('valider', SubmitType::class);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'P4\MuseumBundle\Entity\Orders'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'p4_museumbundle_orders';
    }
}