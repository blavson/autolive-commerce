<?php

namespace App\Form;

use App\Entity\Maker;
use App\Entity\Model;
use App\Repository\CarRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomepageFormType extends AbstractType {

    private $carRepository;

    function __construct(CarRepository $carRepository) {
        $this->carRepository = $carRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('car_makers', EntityType::class, [
            'class' => Maker::class,
            'placeholder' => 'Car Makers',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);
        $builder->add('car_models', ChoiceType::class, [
//            'class' => Model::class,
            'placeholder' => 'Car Models',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);
        $builder->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
        ]);
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
//        $builder->addEventListener(
//            FormEvents::PRE_SET_DATA,
//            function (FormEvent $event) {
//                // this would be your entity, i.e. SportMeetup
//                $form = $event->getForm();
//                $data = $event->getData();
//            }
//        );

    }

    function onPresetData(FormEvent $event) {
        if (!empty($event->getData()))
            dd($event->getData());
    }

    function onPreSubmit(FormEvent $event) {
        $data = $event->getData();

        $car_makers = $data['car_makers'];
        $car_models = $data['car_models'];
        $cars = $this->carRepository->createQueryBuilder('query')
                ->where("query.maker = :car_maker")
            ->andWhere("query.model = :car_model")
            ->setParameter('car_maker', $car_makers)
            ->setParameter('car_model', $car_models)
            ->getQuery()
            ->execute();
        dd($cars);

    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
