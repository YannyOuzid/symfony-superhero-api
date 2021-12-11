<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MissionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mission::class;
    }

    public function createEntity(string $entityFqcn) {
        $user = $this->getUser();
        $entity = new Mission();
        $entity->setClient($user);
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
            ChoiceField::new('statut')->setChoices(
                [
                    'To review' => 'To review',
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
            DateField::new('date'),
            DateField::new('release_date'),
            AssociationField::new('wicked'),
            AssociationField::new('hero'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::NEW, 'ROLE_CLIENT');
    }
}
