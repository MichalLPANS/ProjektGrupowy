<?php

namespace App\Controller\Admin;

use App\Entity\Transakcje;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class TransakcjeCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Transakcje::class;
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      NumberField::new('ilosc_biletow', 'Ilość biletów'),
    ];
  }
}
