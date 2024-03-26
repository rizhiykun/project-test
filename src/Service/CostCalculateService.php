<?php

namespace App\Service;

use DateTime;

class CostCalculateService
{
    // Расчёт стоимости путешествия с учётом скидок
    public function calculate(
        int $baseCost,
        DateTime $tripStartDate,
        DateTime $participantBirthDate,
        DateTime $paymentDate
    ): int {
        $age = $tripStartDate->diff($participantBirthDate)->y;
        $childDiscount = 0;
        $earlyBookingDiscount = 0;
        $maxChildDiscount = 4500;

        // Детская скидка
        if ($age >= 12) {
            $childDiscount = $baseCost * 0.10;  // 10% скидка
        } elseif ($age >= 6) {
            $childDiscount = min($baseCost * 0.30, $maxChildDiscount);  // 30% скидка, но не более 4500 руб.
        } elseif ($age >= 3) {
            $childDiscount = $baseCost * 0.80;  // 80% скидка
        }

        $costAfterChildDiscount = $baseCost - $childDiscount;

        // Скидка за раннее бронирование
        $startYear = (int)$tripStartDate->format('Y');
        $paymentYear = (int)$paymentDate->format('Y');

        if ($tripStartDate >= new DateTime("$startYear-04-01") && $tripStartDate <= new DateTime("$startYear-09-30")) {
            if ($paymentDate <= new DateTime("$paymentYear-11-30")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.07, 1500);  // 7% скидка, но не более 1500 руб.
            } elseif ($paymentDate <= new DateTime("$paymentYear-12-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.05, 1500);  // 5% скидка
            } elseif ($paymentDate <= new DateTime(($paymentYear + 1) . "-01-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.03, 1500);  // 3% скидка
            }
        } elseif ($tripStartDate >= new DateTime("$startYear-10-01") && $tripStartDate <= new DateTime(($startYear + 1) . "-01-14")) {
            if ($paymentDate <= new DateTime("$paymentYear-03-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.07, 1500);  // 7% скидка
            } elseif ($paymentDate <= new DateTime("$paymentYear-04-30")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.05, 1500);  // 5% скидка
            } elseif ($paymentDate <= new DateTime("$paymentYear-05-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.03, 1500);  // 3% скидка
            }
        } elseif ($tripStartDate >= new DateTime(($startYear + 1) . "-01-15")) {
            if ($paymentDate <= new DateTime("$paymentYear-08-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.07, 1500);  // 7% скидка
            } elseif ($paymentDate <= new DateTime("$paymentYear-09-30")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.05, 1500);  // 5% скидка
            } elseif ($paymentDate <= new DateTime("$paymentYear-10-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.03, 1500);  // 3% скидка
            }
        }

        // Итоговая стоимость
        return $costAfterChildDiscount - $earlyBookingDiscount;
    }
}