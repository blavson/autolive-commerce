<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomepageFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $makers = $options['data']['makers'];
//        dd($makers);
//        $marray = ['Cars'=>0];
//        foreach ($makers as $maker)
//            $marray[$maker->getMaker()] = $maker->getId();
//        $makers = $options
        $builder->add('car_makers', ChoiceType::class, [
            'choices'  => [
                'Cars' => $makers
            ],
        ]);
        $builder->Add('car_models');
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();
//                dd($data);
//                $formModifier($event->getForm(), $data->getSport());
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
