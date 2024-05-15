<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class EventCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Event::class;
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      TextField::new('miasto', 'Miasto'),
      NumberField::new('cena', 'Cena'),
      TextareaField::new('opis', 'Opis wydarzenia'),
      NumberField::new('ilosc', 'Ilość'),
    ];
  }
}
