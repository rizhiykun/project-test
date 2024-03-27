<?php

namespace App\Tests;

use App\Service\CostCalculateService;
use DateTime;

class CostCalculateServiceTest extends TestCase
{
    private CostCalculateService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CostCalculateService();
    }

    public function testChildDiscount()
    {
        $baseCost = 10000;
        $tripStartDate = new DateTime('2024-01-01');
        $paymentDate = new DateTime('');

        // Дети до 3 лет (80% скидка)
        $participantBirthDate = new DateTime('2020-01-01');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(2000, $totalCost);

        // Дети от 6 до 12 лет (30% скидка, но не более 4500 руб.)
        $participantBirthDate = new DateTime('2015-01-01');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(7000, $totalCost);

        // Дети от 12 лет и старше (10% скидка)
        $participantBirthDate = new DateTime('2010-01-01');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(9000, $totalCost);
    }

    public function testEarlyBookingDiscount()
    {
        $baseCost = 10000;
        $tripStartDate = new DateTime('2025-04-02');
        $participantBirthDate = new DateTime('2010-01-01');

        $paymentDate = new DateTime('2024-11-01');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(8370, $totalCost);

        $paymentDate = new DateTime('2024-12-01');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(8550, $totalCost);

        $paymentDate = new DateTime('2025-01-31');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(8730, $totalCost);


        $tripStartDate = new DateTime('2024-10-02');

        $paymentDate = new DateTime('2024-03-01');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(8370, $totalCost);

        $paymentDate = new DateTime('2024-04-01');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(8550, $totalCost);

        $paymentDate = new DateTime('2024-05-31');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(8730, $totalCost);

        $tripStartDate = new DateTime('2025-01-16');

        $paymentDate = new DateTime('2024-08-01');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(8370, $totalCost);

        $paymentDate = new DateTime('2024-09-01');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(8550, $totalCost);

        $paymentDate = new DateTime('2024-10-31');
        $totalCost = $this->service->calculate($baseCost, $tripStartDate, $participantBirthDate, $paymentDate);
        $this->assertEquals(8730, $totalCost);
    }

}