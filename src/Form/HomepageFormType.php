<?php

namespace App\Form;

use App\Entity\Maker;
use App\Repository\MakerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;

class HomepageFormType extends AbstractType {

    private $makerRepository;

    function __construct(MakerRepository $makerRepository) {
        $this->makerRepository = $makerRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('car_makers', EntityType::class, [
            'class' => Maker::class,
            'placeholder' => 'Car Maker',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);
        $m['All models'] = 0;
        $builder->add('car_models', ChoiceType::class, [
//            'placeholder' => 'Car Model',
//            'class' => Model::class,
                'attr' => [
                    'class' => 'form-control'
                ],
//                'choices' => [
//                    'All Model' => 0
//                    ]
            ]

        );
        $builder->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn-block mt-2',
                ]
        ]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

    }

    protected function addElements(FormInterface $form, Maker $maker = null) {
        // 4. Add the province element
        $form->add('car_makers', EntityType::class, [
            'required' => true,
            'data' => $maker,
            'placeholder' => 'Car Maker',
            'class' => Maker::class,
            'attr' => [
                'class' => 'form-control'
          ]
        ]);

        $m = [];
        if (!is_null($maker)) {
            $models = $this->makerRepository->findOneBy(['id' => $maker->getId()])->getModels();
            $m['All Model'] = 0;
            foreach ($models as $model) {
                $m[$model->getModel()] = $model->getId();
            }
        }
        $form->add('car_models', ChoiceType::class, [
//            'placeholder' => 'Car Model',
//            'class' => Model::class,
            'attr' => [
                        'class' => 'form-control'
                    ],
             'choices' =>  $m
            ]
        );

    }

    function onPresetData(FormEvent $event) {
        $maker = $event->getData();
        $form = $event->getForm();

       $this->addElements($form, $maker);

    }

    function onPreSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $maker = $this->makerRepository->find($data['car_makers']);
        $this->addElements($form, $maker);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
