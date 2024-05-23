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
      
      if ($event == null) {
        return $this->redirectToRoute('app_nadmiar');
      }

      $ilosc_kupionych_biletow = $event->getBilety();
      $suma = 0;

      foreach ($ilosc_kupionych_biletow as $key => $value) {
        $suma += $value->getIloscBiletow();
      }

      if ($suma + $ilosc > $event->getIlosc() or $ilosc <=0) {
        return $this->redirectToRoute('app_nadmiar');
      }
      $transakcja = new Transakcje();
      $transakcja->setUser($user);
      $transakcja->setEvents($event);
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

  #[Route('/event/{id}', name: 'app_event')]
  public function event(int $id, EntityManagerInterface $entityManager): Response
  {
    $event = $entityManager->getRepository(Event::class)->find($id);
    return $this->render(
      'main/event.html.twig',
      ["event" => $event]
    );
  }

  #[Route('/ticket', name: 'app_user_ticket')]
  public function ticket(UserInterface $user): Response
  {
    $ticket = $user->getTransakcjes();
    return $this->render(
      'main/ticket.html.twig',
      ["ticket" => $ticket]
    );
  }

  #[Route('/add/event', name: 'app_add_event')]
  public function add_event(EntityManagerInterface $entityManager, Request $request): Response
  {
    if ($request->isMethod('POST')) {
      $event_miasto = $request->request->get('miasto');
      $event_cena = $request->request->get('cena');
      $event_opis = $request->request->get('opis');
      $event_ilosc = $request->request->get('ilosc');

      $event = new Event();
      $event->setMiasto($event_miasto);
      $event->setCena($event_cena);
      $event->setOpis($event_opis);
      $event->setIlosc($event_ilosc);
      
      $entityManager->persist($event);
      $entityManager->flush();
    }
    return $this->render(
      'main/add_event.html.twig'
    );
  }
}
