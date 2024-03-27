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
        $maxAdultDiscount = 1500;

        // Детская скидка
        if ($age >= 12 && $age < 18) {
            $childDiscount = $baseCost * 0.10;  // 10% скидка
        } elseif ($age >= 6 && $age < 12) {
            $childDiscount = min($baseCost * 0.30, $maxChildDiscount);  // 30% скидка, но не более 4500 руб.
        } elseif ($age >= 3 && $age < 6) {
            $childDiscount = $baseCost * 0.80;  // 80% скидка
        }

        $costAfterChildDiscount = $baseCost - $childDiscount;

        // Раннее бронирование
        // Старт периода 01.04.2025 - 30.09.2025
        // Летний период с оплатой с 1 ноября до 31 января
        if ($tripStartDate >= new DateTime("2025-04-01") && $tripStartDate <= new DateTime("2025-09-30")) {
            if ($paymentDate <= new DateTime("2024-11-30")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.07, $maxAdultDiscount);  // 7% скидка, но не более 1500 руб.
            } elseif ($paymentDate <= new DateTime("2024-12-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.05, $maxAdultDiscount);  // 5% скидка
            } elseif ($paymentDate <= new DateTime("2025-01-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.03, $maxAdultDiscount);  // 3% скидка
            }
            // Старт периода 01.10.2024 - 14.01.2025
        // Зимний период с оплатой с 1 марта до 31 мая
        } elseif ($tripStartDate >= new DateTime("2024-10-01") && $tripStartDate <= new DateTime("2025-01-14")) {
            if ($paymentDate <= new DateTime("2024-03-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.07, $maxAdultDiscount);  // 7% скидка
            } elseif ($paymentDate <= new DateTime("2024-04-30")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.05, $maxAdultDiscount);  // 5% скидка
            } elseif ($paymentDate <= new DateTime("2024-05-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.03, $maxAdultDiscount);  // 3% скидка
            }
        //старт периода 15.01.2025 - ...
            // Весенний период с оплатой с 1 августа до 31 октября
        } elseif ($tripStartDate >= new DateTime( "2025-01-15")) {
            if ($paymentDate <= new DateTime("2024-08-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.07, $maxAdultDiscount);  // 7% скидка
            } elseif ($paymentDate <= new DateTime("2024-09-30")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.05, $maxAdultDiscount);  // 5% скидка
            } elseif ($paymentDate <= new DateTime("2024-10-31")) {
                $earlyBookingDiscount = min($costAfterChildDiscount * 0.03, $maxAdultDiscount);  // 3% скидка
            }
        }

        // Итоговая стоимость
        return $costAfterChildDiscount - $earlyBookingDiscount;
    }
}