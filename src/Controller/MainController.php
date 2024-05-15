<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Transakcje;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MainController extends AbstractController
{
  // #[Route('/main', name: 'app_main')]
  // public function index(): Response
  // {
  //     return $this->render('main/index.html.twig', [
  //         'controller_name' => 'MainController',
  //     ]);
  // }

  #[Route('/', name: 'app_home')]
  public function home(): Response
  {
    return $this->render('main/home.html.twig');
  }

  #[Route('/list', name: 'app_list')]
  public function list(EntityManagerInterface $entityManager): Response
  {
    $events = $entityManager->getRepository(Event::class)->findAll();
    return $this->render('main/list.html.twig', ["events" => $events]);
  }

  #[Route('/buy', name: 'app_buy')]
  public function buy(UserInterface $user, Request $request, EntityManagerInterface $entityManager): Response
  {
    $event_id = $request->request->get('event');
    if ($request->isMethod('POST')) {
      $ilosc = $request->request->get('ilosc');
      $event = $entityManager->getRepository(Event::class)->find($event_id);
      $ilosc_kupionych_biletow = $event->getBilety();
      $suma = 0;

      foreach ($ilosc_kupionych_biletow as $key => $value) {
        $suma += $value->getIloscBiletow();
      }

      if ($suma + $ilosc > $event->getIlosc()) {
        return $this->redirectToRoute('app_nadmiar');
      }
      $transakcja = new Transakcje();
      $transakcja->setUser($user);
      $transakcja->addEvent($event);
      $transakcja->setIloscBiletow($ilosc);

      $entityManager->persist($transakcja);
      $entityManager->flush();
    }
    return $this->redirectToRoute('app_kupione');
  }

  #[Route('/kupione', name: 'app_kupione')]
  public function kupione(): Response
  {
    return $this->render('main/kupione.html.twig');
  }

  #[Route('/nadmiar', name: 'app_nadmiar')]
  public function nadmiar(): Response
  {
    return $this->render('main/nadmiar.html.twig');
  }
}
