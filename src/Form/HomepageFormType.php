<?php

namespace App\Form;

use App\Entity\Maker;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomepageFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('car_makers', EntityType::class, [
            'class' => Maker::class,
            'placeholder' => 'Car Makers',
        ]);
        $builder->add('car_models', ChoiceType::class, [
//            'class' => Model::class,
            'placeholder' => 'Car Models',
        ]);
        $builder->add('submit_button', SubmitType::class, [

        ]);
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                // this would be your entity, i.e. SportMeetup
                $form = $event->getForm();
                $data = $event->getData();
//                $formModifier($event->getForm(), $data->getSport());
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
