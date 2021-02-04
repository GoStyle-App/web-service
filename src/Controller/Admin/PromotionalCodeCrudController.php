<?php

namespace App\Controller\Admin;

use App\Entity\PromotionalCode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PromotionalCodeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PromotionalCode::class;
    }
}
