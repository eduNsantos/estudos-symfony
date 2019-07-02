<?php

namespace App\Form;

use App\Entity\Specialty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SpecialtyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextareaType::class, [
                'label' => 'Especialidades',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'help' => 'Cadastre multiplas especilidades as separando por vírgula!'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Salvar categoria(s)',
                'attr' => [
                    'class' => 'form-control btn-primary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialty::class,
        ]);
    }
}
