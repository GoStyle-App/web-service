<?php

namespace App\Controller\Admin;

use App\Entity\PromotionalCode;
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
            ->setTitle('GoReduc Admin');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToCrud('Code promo', 'fa fa-tags', PromotionalCode::class),
        ];
    }
}
