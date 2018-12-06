<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('surname', TextType::class)
            ->add('name', TextType::class)
            ->add('position', TextType::class)
            ->add('employmentDate', DateType::class, array(
                'widget' => 'single_text'))
            ->add('salary', MoneyType::class, array(
                'currency' => 'USD'))
            ->add('image', FileType::class, array('label' => 'Image', 'data_class'=>null, 'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Employee',
            'allow_extra_fields' => true,
        ]);
    }
    public function getName()
    {
        return 'user';
    }

}