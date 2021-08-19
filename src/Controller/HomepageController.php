<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index(): Response  {
        $daytime = 'night';
        if ($daytime == 'morning')
            $greet = "Good morning";
        else
            $greet = "What ever the fuck you want";
        return $this->render('homepage.php.twig', ['greet' => $greet]);
    }
}
