<?php

namespace App\Controller;

use App\Entity\Maker;
use App\Form\HomepageFormType;
use App\Repository\CarRepository;
use App\Repository\MakerRepository;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index( Request $request, MakerRepository $makerRepository, CarRepository $carRepository): Response  {
      $myform = $this->createForm(HomepageFormType::class);
      $cars =[];
      $myform->handleRequest($request);
//
        if ($myform->isSubmitted()) {
            $car_maker = $request->request->get('homepage_form')['car_makers'];
            $car_model = $request->request->get('homepage_form')['car_models'];
            $cars = $carRepository->findBy(['maker' => $car_maker, 'model' => $car_model]);
        }

        return $this->render('homepage.php.twig', ['myform' => $myform->createView(), 'cars' => $cars]);
    }

    /**
     * @Route("/test", name="test")
     */

    public function justText(Request $request, MakerRepository $makerRepository) {
        $maker = $makerRepository->find(['id' => 92]);
        $marray = $maker->getModels()->toArray();
        dd($marray);
    }


    /**
     * @Route("/get_models_by_maker", name="get_models_by_maker")
     */

    public function modelsByMaker(Request $request, ModelRepository $modelRepository) : JsonResponse {
        $maker_id = $request->query->get('maker_id');
        $models = $modelRepository->findBy(['maker' => $maker_id]);
        $mArray = [];
        foreach ($models as $m) {
            $mArray[$m->getModel()] = $m->getId();
        }
        return new JsonResponse($mArray);
    }
}
