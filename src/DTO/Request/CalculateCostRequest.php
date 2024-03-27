<?php

namespace App\DTO\Request;

use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CalculateCostRequest implements RequestDTOInterface
{

    /**
     * @Assert\NotNull()
     */
    private int $baseCost;

    /**
     * @Assert\Date()
     */
    private DateTime $tripStartDate;

    /**
     * @Assert\NotNull()
     * @Assert\Date()
     */
    private DateTime $participantBirthDate;

    /**
     * @Assert\Date()
     */
    private DateTime $paymentDate;
    public function __construct(Request $request)
    {
        $this->baseCost = $request->get('base_cost');
        $this->tripStartDate = new DateTime($request->get('trip_start_date'));
        $this->participantBirthDate = new DateTime($request->get('participant_birth_date'));
        $this->paymentDate = empty($request->get('payment_date')) ?
            new DateTime() :
            new DateTime($request->get('payment_date'))
        ;
    }

    public function getBaseCost(): int
    {
        return $this->baseCost;
    }

    public function getTripStartDate(): DateTime
    {
        return $this->tripStartDate;
    }

    public function getParticipantBirthDate(): DateTime
    {
        return $this->participantBirthDate;
    }

    public function getPaymentDate(): DateTime
    {
        return $this->paymentDate;
    }
}