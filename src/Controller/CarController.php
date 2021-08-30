<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @Route("/car", name="car")
     */
    public function index(): Response
    {
        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }


/**
 * @Route ("/car/{car_id}", name="show_car")
 */
  public function show(CarRepository $carRepository, $car_id) : Response {
    $car = $carRepository->find(['id' => $car_id]);
    return $this->render('car/show.php.twig', ['car' => $car]);
  }
}
