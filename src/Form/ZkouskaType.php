<?php

namespace App\Form;

use App\Entity\Zkouska;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZkouskaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jmeno',TextType::class,[
                'label' => 'Jméno yetiho'
            ])
            ->add('informace',TextType::class,[
                'label' => 'Něco o něm'
            ])
            ->add('height',TextType::class,[
                'label' => 'Jeho hmotnost (Kg)'
            ])
            ->add('weight',TextType::class,[
                'label' => 'Jeho výška (cm)'
            ])
            ->add('frajer')
            ->add('smradoch')
            ->add('chytrak')
            ->add('slusnak')
            ->add('img', FileType::class, [
                'mapped' => false,
                'label' => 'Vyberte obrázek',
                'attr' => [
                'accept' => 'image/*'
                ],
            ])
            ->add( 'datum', BirthdayType::class,[
                'label' => 'Datum narození',
                'format' => 'dd-MMM-yyyy'
              //  'years' => range(Date('Y'), 1960),
            ])
  



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zkouska::class,
        ]);
    }
}
