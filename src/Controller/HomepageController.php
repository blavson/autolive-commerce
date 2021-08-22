<?php

namespace App\Controller;

use App\Entity\Maker;
use App\Form\HomepageFormType;
use App\Repository\MakerRepository;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index( Request $request, MakerRepository $makerRepository): Response  {
      $myform = $this->createForm(HomepageFormType::class);
      $carItems = [];
      $myform->handleRequest($request);
        if ($myform->isSubmitted() ) {
            dd($request);
        }
        if ($request->isMethod('post')) {
            $req = $request->toArray();
            $maker_id = $req['maker_id'];
            $maker = $makerRepository->find(['id' => $maker_id]);
            $models =  $maker->getModels()->toArray();
            foreach ($models as $m)
                $marray[$m->getModel()] = $m->getId();
            return new Response(json_encode($marray));
        }


        return $this->render('homepage.php.twig', ['myform' => $myform->createView(), 'carItems' => $carItems]);
    }

    /**
     * @Route("/test", name="test")
     */

    public function justText(Request $request, MakerRepository $makerRepository) {
        $maker = $makerRepository->find(['id' => 92]);
        $marray = $maker->getModels()->toArray();
        dd($marray);
    }

}
