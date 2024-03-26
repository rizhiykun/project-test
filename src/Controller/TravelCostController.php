<?php

namespace App\Controller;

use App\DTO\Request\CalculateCostRequest;
use App\Service\CostCalculateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TravelCostController extends AbstractController
{
    private CostCalculateService $costCalculateService;
    public function __construct(CostCalculateService $costCalculateService)
    {
        $this->costCalculateService = $costCalculateService;
    }

    #[Route('/travel/cost', name: 'app_travel_cost')]
    public function index(): Response
    {
        return $this->render('travel_cost/index.html.twig', [
            'controller_name' => 'TravelCostController',
        ]);
    }
    #[Route('/travel/calculate', name: 'app_travel_calculate',methods: 'POST')]
    public function calculate(CalculateCostRequest $request): JsonResponse
    {
        $totalCost = $this->costCalculateService->calculate(
           $request->getBaseCost(),
           $request->getTripStartDate(),
           $request->getParticipantBirthDate(),
           $request->getPaymentDate()
       );

        // Возвращаем итоговую стоимость в формате JSON
        return new JsonResponse(['totalCost' => $totalCost]);
    }

}
