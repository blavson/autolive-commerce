<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Maker;
use App\Entity\Model;
use App\Repository\MakerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            'placeholder' => 'Car Makers',
            'attr' => [
                'class' => 'form-control'
            ]
        ]);
//        $builder->add('car_models', EntityType::class);
        $builder->add('car_models', EntityType::class, [
            'placeholder' => 'Car Models',
            'class' => Model::class,
            'choices' => [],
        ]);
        $builder->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-2',
                ]
        ]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
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

    protected function addElements(FormInterface $form, Maker $maker = null) {
        // 4. Add the province element
        $form->add('car_makers', EntityType::class, [
            'required' => true,
            'data' => $maker,
            'placeholder' => 'Car Makers',
            'class' => Maker::class
        ]);

        $models = [];

        // If there is a city stored in the Person entity, load the neighborhoods of it
        if (!is_null($maker)) {
            // Fetch Neighborhoods of the City if there's a selected city

//            $models = $this->makerRepository->createQueryBuilder("q")
//                ->where("q.maker = :maker_id")
//                ->setParameter("maker_id", $maker->getId())
//                ->getQuery()
//                ->getResult();

            $models = $this->makerRepository->findOneBy(['id' => $maker->getId()])->getModels();
//            dd(__function__, $maker,  $models);

        }
            $form->add('car_models', EntityType::class, [
                'placeholder' => 'Select a maker first',
                'class' => Model::class,
                'choices' => $models
            ]);
    }

    function onPresetData(FormEvent $event) {
        $maker = $event->getData();
        $form = $event->getForm();

       $this->addElements($form, $maker);


//        $this->addElements($form, $city);

    }



    function onPreSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

//        if (!empty($data))
//            dd(__function__, $data);

        $maker = $this->makerRepository->find($data['car_makers']);

        $this->addElements($form, $maker);
//        if (!empty($data))
//            dd(__function__, $data);

//        $car_makers = $data['car_makers'];
//        $car_models = $data['car_models'];
//        $cars = $this->carRepository->createQueryBuilder('query')
//                ->where("query.maker = :car_maker")
//            ->andWhere("query.model = :car_model")
//            ->setParameter('car_maker', $car_makers)
//            ->setParameter('car_model', $car_models)
//            ->getQuery()
//            ->getResult();
//            $form->setData(['cars'=> $cars]);
//        return new Response($cars);

    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
