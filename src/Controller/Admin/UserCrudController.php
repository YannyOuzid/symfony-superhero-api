<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('name'),
            TextField::new('password')->hideOnIndex(),
            ChoiceField::new('roles')->setChoices(
                [
                    'admin' => 'ROLE_ADMIN',
                    'Hero' => 'ROLE_SUPER_HERO',
                    'Client' => 'ROLE_CLIENT'
                ],
            )->allowMultipleChoices()
        ];
    }
}
