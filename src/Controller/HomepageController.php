<?php

namespace App\Controller;

use App\Form\HomepageFormType;
use App\Repository\MakerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index( MakerRepository  $makerRepository): Response  {
      $makers = $makerRepository->findAll();
        foreach ($makers as $maker)
            $marray[$maker->getMaker()] = $maker->getId();
      $models = [];
      $myform = $this->createForm(HomepageFormType::class , ['makers' => $marray,'models' => $models ]);
        return $this->render('homepage.php.twig', ['myform' => $myform->createView()]);
    }
}
