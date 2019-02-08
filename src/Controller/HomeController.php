<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PropertyRepository;



Class HomeController extends AbstractController
{

    // /**
    // * @var Environment
    // **/
    // private $twig;

    // /**
    // * @var PropertyRepository
    // */
    //
    // private $repository;



  /**
  * @Route("/", name="home")
  * @param PropertyRepository $repository
  * @return Response
  */

  public function index(PropertyRepository $repository): Response
  {

    $properties = $repository->findAll();
    dump($properties);


    return $this->render('pages/home.html.twig', [
        'properties' => $properties
    ]);
  }
}
