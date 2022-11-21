<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => (array)[
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_SALES' => 'ROLE_SALES',
                    'ROLE_SHIP' => 'ROLE_SHIP',
                    'ROLE_PRO' => 'ROLE_PRO',
                    'ROLE_CLIENT' => 'ROLE_CLIENT',
                    'ROLE_USER' => 'ROLE_USER',
                ],
                'mapped' => true,
                'multiple' => true,
                'help' => 'Maintenez Ctrl pour sélectionner plusieurs rôles',
                'required' => false,
            ])
            ->add('name')
            ->add('lastName')
            ->add('birthdate')
            ->add('signinDate')
            ->add('phoneNumber')
            ->add('isVerified')
            ->add('vat')
            ->add('pro')
            ->add('proCompanyName')
            ->add('proDuns');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
