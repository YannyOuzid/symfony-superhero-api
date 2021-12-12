<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->renderContentMaximized();
    }

    public function configureFields(string $pageName): iterable
    {
        $form = [
            TextField::new('email'),
            TextField::new('name'),
            TextField::new('password')->hideOnIndex(),
        ];

        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
           $form[] = ChoiceField::new('roles')->setChoices(
               [
                   'admin' => 'ROLE_ADMIN',
                   'Hero' => 'ROLE_SUPER_HERO',
                   'Client' => 'ROLE_CLIENT'
               ],
           )->allowMultipleChoices();
        }
        return $form;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $entityRepository = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $entityRepository->where('entity.id = :id');
            $entityRepository->setParameter('id', $this->getUser());
        }
        return $entityRepository;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->setPermission(Action::DELETE, 'ROLE_ADMIN')->setPermission(Action::NEW, 'ROLE_ADMIN');
    }
}
