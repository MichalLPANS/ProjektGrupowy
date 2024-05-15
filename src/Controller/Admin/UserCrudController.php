<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
  private UserPasswordHasherInterface $passwordEncoder;
  public function __construct(UserPasswordHasherInterface $passwordEncoder)
  {
    $this->passwordEncoder = $passwordEncoder;
  }

  public static function getEntityFqcn(): string
  {
    return User::class;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setDefaultSort(['id' => 'ASC']);
  }

  public function configureActions(Actions $actions): Actions
  {
    return $actions
      ->add(Crud::PAGE_INDEX, Action::DETAIL);
  }


  public function configureFields(string $pageName): iterable
  {
    $roles = ['ROLE_USER', 'ROLE_ADMIN'];
    return [
      TextField::new('email', 'Adres mail'),
      Field::new('password', 'New password')->onlyWhenUpdating()->setRequired(false)
        ->setFormType(RepeatedType::class)
        ->setFormTypeOptions(
          [
            'type'            => PasswordType::class,
            'first_options'   => ['label' => 'Nowe hasło'],
            'second_options'  => ['label' => 'Powtórz hasło'],
            'error_bubbling'  => true,
            'invalid_message' => 'Podane hasła nie są takie same.',
          ]
        ),
      Field::new('password', 'New password')->onlyWhenCreating()->setRequired(true)
        ->setFormType(RepeatedType::class)
        ->setFormTypeOptions(
          [
            'type'            => PasswordType::class,
            'first_options'   => ['label' => 'Podaj hasło'],
            'second_options'  => ['label' => 'Powtórz hasło'],
            'error_bubbling'  => true,
            'invalid_message' => 'Podane hasła nie są takie same.',
          ]
        ),
      ChoiceField::new('roles', 'Role użytkownika')
        ->setChoices(array_combine($roles, $roles))
        ->allowMultipleChoices()
        ->renderAsBadges(),
      AssociationField::new('transakcjes', 'Transakcje'),
    ];
  }
  public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
  {
    $plainPassword = $entityDto->getInstance()->getPassword();
    $formBuilder   = parent::createEditFormBuilder($entityDto, $formOptions, $context);
    $this->addEncodePasswordEventListener($formBuilder, $plainPassword);

    return $formBuilder;
  }

  public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
  {
    $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
    $this->addEncodePasswordEventListener($formBuilder);

    return $formBuilder;
  }

  protected function addEncodePasswordEventListener(FormBuilderInterface $formBuilder, $plainPassword = null): void
  {
    $formBuilder->addEventListener(
      FormEvents::SUBMIT,
      function (FormEvent $event) use ($plainPassword) {
        /**
         * @var User $user 
         */
        $user = $event->getData();
        if ($user->getPassword() !== $plainPassword) {
          $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getPassword()));
        }
      }
    );
  }
}
