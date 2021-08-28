<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Maker;
use App\Entity\Model;
use App\Form\HomepageFormType;
use App\Repository\CarRepository;
use App\Repository\MakerRepository;
use App\Repository\ModelRepository;
use Doctrine\ORM\Query;
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
    public function index( Request $request, MakerRepository $makerRepository ,CarRepository $carRepository): Response  {
      $myform = $this->createForm(HomepageFormType::class);
      $myform->handleRequest($request);
      $cars = $carRepository->findBy([],['release_date' => 'desc'], 10, 0);
//      dd($request, $cars);

//        $cars = $carRepository->createQueryBuilder('car')
//            ->leftJoin(Model::class, 'model', Query\Expr\Join::WITH , 'car.model = model.id')
//            ->orderBy('car.release_date', 'desc')
//            ->getQuery()
//            ->getResult();
//        dd($cars);
        if ($myform->isSubmitted()) {
            $maker_id = $request->request->get('homepage_form')['car_makers'];
            $model_id = $request->request->get('homepage_form')['car_models'];

//            dd($maker_id, $model_id);
            $query = $carRepository->createQueryBuilder('q')
                ->where('q.maker_id = :maker_id')
                ->setParameter('maker_id', $maker_id);
            if ($model_id) {
                $query->andWhere('q.model_id = :model_id');
                $query->setParameter('model_id', $model_id);
            }
            $cars = $query->getQuery()->getResult();
        }
            return $this->render('homepage.php.twig', ['myform' => $myform->createView(), 'cars' => $cars  ]);
    }


    /**
     * @Route("/get_models_by_maker", name="get_models_by_maker")
     */

    public function modelsByMaker(Request $request, MakerRepository $makerRepository) : JsonResponse {
        $maker_id = $request->query->get('maker_id');
        $models = $makerRepository->find(['id' =>$maker_id])->getModels();

        $mArray = [];
        foreach ($models as $m) {
            $mArray[$m->getModel()] = $m->getId();
        }
        return new JsonResponse($mArray);
    }
}
