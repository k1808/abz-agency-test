<?php

namespace App\services;

use DateInterval;
use DateTime;

class DateTimeService
{
    public static function isExpired($tokenCreatedAt)
    {

        $tokenCreatedAt = new DateTime($tokenCreatedAt);
        $currentTime = new DateTime();

        // Добавляем 40 минут к времени создания токена
        $expirationTime = clone $tokenCreatedAt;
        $expirationTime->add(new DateInterval('PT40M'));

        // Сравниваем с текущим временем
        return $currentTime >= $expirationTime;
    }
}
