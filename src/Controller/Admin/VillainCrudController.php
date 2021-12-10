<?php

namespace App\Controller\Admin;

use App\Entity\Villain;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VillainCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Villain::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
