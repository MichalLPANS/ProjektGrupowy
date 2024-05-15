<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Transakcje;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
  #[Route('/admin', name: 'app_admin')]
  public function index(): Response
  {
    $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
    return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
  }

  public function configureDashboard(): Dashboard
  {
    return Dashboard::new()
      ->setTitle('Panel Admina')
      ->renderContentMaximized()
      ->renderSidebarMinimized()
      ->disableDarkMode()
      ->setLocales(['pl' => 'Polski'])
      ->generateRelativeUrls();
  }

  public function configureMenuItems(): iterable
  {
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-table-columns');
    yield MenuItem::linkToUrl('Strona główna', 'fa fa-home', '/');
    yield MenuItem::linkToCrud('Użytkownicy', 'fas fa-user', User::class);
    yield MenuItem::linkToCrud('Wydarzenia', 'fas fa-star', Event::class);
    yield MenuItem::linkToCrud('Transakcje', 'fas fa-repeat', Transakcje::class);
  }
}
