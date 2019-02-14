<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Contact;
use App\Form\OptionType;
use App\Entity\Picture;
use App\Form\ContactType;
use App\Entity\PropertySearch;
use App\Notification\ContactNotification;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;



class PropertyController extends AbstractController
{

  /**
  * @var PropertyRepository
  */

  private $repository;

  /**
  * @var ObjectManager
  */
  private $em;




  public function __construct(PropertyRepository $repository, ObjectManager $em)
  {
    $this->repository = $repository;
    $this->em = $em;
  }




  /**
  * @Route("/biens", name="property.index")
  * @return Response
  */

  public function index(PaginatorInterface $paginator,Request $request): Response
  {

      $search = new PropertySearch();
      $form = $this->createForm(PropertySearchType::class, $search);
      $form->handleRequest($request);



      $properties = $paginator->paginate(
      $this->repository->findAllVisibleQuery($search),
      $request->query->getInt('page', 1),
         9
    );



      return $this->render('property/index.html.twig', [
          'current_menu' => 'properties',
          'properties' => $properties,
          'form' => $form->createView()
      ]);
  }


  /**
  * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
  * @return Response
  */


  public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response
  {



    if ($property->getSlug() === $slug) {
      $this->redirectToRoute('property.show', [
        'id' => $property->getId(),
        'slug' => $property->getSlug()
      ], 301);
    }

    $contact = new Contact();
    $contact->setProperty($property);
    $form = $this->createForm(ContactType::class, $contact);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $notification->notify($contact);
      $this->addFlash('success', 'Votre email a bien été envoyé');
      return $this->redirectToRoute('property.show', [
        'id' => $property->getId(),
        'slug' => $property->getSlug()
      ]);
    }

    return $this->render('property/show.html.twig', [
      'current_menu' => 'properties',
      'property' => $property,
      'form' => $form->createView()
    ]);
  }







}
