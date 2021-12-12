<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Entity\User;
use App\Entity\Villain;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Api Platform Project');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Missions List', 'fas fa-list', Mission::class);
        yield MenuItem::linkToCrud('Villain List', 'fas fa-list', Villain::class)->setPermission('ROLE_ADMIN');
        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            yield MenuItem::linkToCrud('User List', 'fas fa-list', User::class);
        } else {
            yield MenuItem::linkToCrud('Profil', 'fas fa-list', User::class);
        }
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
