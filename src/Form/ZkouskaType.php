<?php

namespace App\Form;

use App\Entity\Zkouska;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZkouskaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jmeno')
            ->add('informace')
            ->add('height')
            ->add('weight')
            ->add('frajer')
            ->add('smradoch')
            ->add('img')



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zkouska::class,
        ]);
    }
}
