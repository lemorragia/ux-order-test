<?php

namespace App\Controller;

use App\Entity\SaleOrder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('')]
class OrderController extends AbstractController
{
    #[Route('', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $type = $request->query->get('type') ?? 'person';
        return $this->render('order/new.html.twig', [
            'order' => new SaleOrder(),
            'type' => $type
        ]);
    }
}
