<?php

namespace App\Tests;

use App\DTO\Request\CalculateCostRequest;
use Symfony\Component\HttpFoundation\Request;

class CalculateCostRequestTest extends TestCase
{
    public function testRequestCreation()
    {
        $request = new Request([
            'base_cost' => 10000,
            'trip_start_date' => '2022-01-01',
            'participant_birth_date' => '2000-01-01',
            'payment_date' => '2021-12-15',
        ]);

        $calculateCostRequest = new CalculateCostRequest($request);

        $this->assertEquals(10000, $calculateCostRequest->getBaseCost());
        $this->assertEquals(new \DateTime('2022-01-01'), $calculateCostRequest->getTripStartDate());
        $this->assertEquals(new \DateTime('2000-01-01'), $calculateCostRequest->getParticipantBirthDate());
        $this->assertEquals(new \DateTime('2021-12-15'), $calculateCostRequest->getPaymentDate());
    }
}