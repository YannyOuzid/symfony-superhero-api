<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class MissionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mission::class;
    }

    public function __construct(EntityRepository $entityRepository) {
        $this->entityRepository = $entityRepository;
    }

    public function createEntity(string $entityFqcn)
    {
        $user = $this->getUser();
        $entity = new Mission();
        $entity->setClient($user);
        $entity->setDate(new \DateTime('now'));
        return $entity;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->renderContentMaximized();
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            TextField::new('client')->hideOnForm(),
            ChoiceField::new('statut')->setChoices(
                [
                    'To validate' => 'To validate',
                    'To do' => 'To do',
                    'In progress' => 'In progress',
                    'Done' => 'Done'
                ],
            )->allowMultipleChoices(false),
            ChoiceField::new('priority')->setChoices(
                [
                    'Low' => 'Low',
                    'Medium' => 'Medium',
                    'High' => 'High',
                ],
            )->allowMultipleChoices(false),
            DateField::new('date', 'Creation date')->hideOnForm(),
            DateField::new('release_date'),
            AssociationField::new('wicked'),
            AssociationField::new('hero')->setFormTypeOptions([
                'query_builder' => function (UserRepository $userRepository) {
                    return $userRepository->createQueryBuilder('a')
                                          ->where('a.roles LIKE :role')
                                          ->setParameter('role', '%"' . 'ROLE_SUPER_HERO' . '"%');
                },]),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $entityRepository = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if (in_array('ROLE_CLIENT' , $this->getUser()->getRoles())) {
            $entityRepository->where('entity.client = :client');
            $entityRepository->setParameter('client', $this->getUser());
        } else if(in_array('ROLE_SUPER_HERO', $this->getUser()->getRoles())) {
            $entityRepository->where('entity.statut != :statut');
            $entityRepository->setParameter('statut', 'To validate');
        }
        return $entityRepository;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            $data = $this;
            return $action->displayIf(static function ($entity) use ($data) {
                if (in_array('ROLE_SUPER_HERO', $data->getUser()->getRoles())) {
                    return true;
                } else {
                    return $entity->getStatut() == 'To validate';
                }
            });
        })->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
            $data = $this;
            return $action->displayIf(static function ($entity) use ($data){
                if (in_array('ROLE_CLIENT', $data->getUser()->getRoles())) {
                    return $entity->getStatut() == 'To validate' || $entity->getStatut() == 'To do';
                } else {
                    return $entity->getStatut() == 'To validate';
                }
            });
        })->setPermission(Action::NEW, 'ROLE_CLIENT');
    }

}
