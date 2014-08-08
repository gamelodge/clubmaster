<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderStatus extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = array(
            'class' => 'form-control'
        );
        $label_attr = array(
            'class' => 'col-sm-2'
        );

        $builder
            ->add('status_name', 'text', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ->add('paid','checkbox',array(
                'required' => false
            ))
            ->add('delivered','checkbox',array(
                'required' => false
            ))
            ->add('cancelled','checkbox',array(
                'required' => false
            ))
            ->add('priority', 'integer', array(
                'attr' => $attr,
                'label_attr' => $label_attr
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Club\ShopBundle\Entity\OrderStatus'
        ));
    }

    public function getName()
    {
        return 'order_status';
    }
}
