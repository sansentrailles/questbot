<?php

declare(strict_types=1);

namespace app\custom\helpers;

class DateHelper
{
    const RU_MONTHS = [
        1 => 'январь',
        2 => 'февраль',
        3 => 'март',
        4 => 'апрель',
        5 => 'май',
        6 => 'июнь',
        7 => 'июль',
        8 => 'август',
        9 => 'сентябрь',
        10 => 'октябрь',
        11 => 'ноябрь',
        12 => 'декабрь',
    ];

    public static $REAL_WEEK = [
        1 => ['short' => 'Пн', 'full' => 'Понедельник'],
        2 => ['short' => 'Вт', 'full' => 'Вторник'],
        3 => ['short' => 'Ср', 'full' => 'Среда'],
        4 => ['short' => 'Чт', 'full' => 'Четверг'],
        5 => ['short' => 'Пт', 'full' => 'Пятница'],
        6 => ['short' => 'Сб', 'full' => 'Суббота'],
        7 => ['short' => 'Вс', 'full' => 'Воскресенье'],
    ];

    public static function getMonth(int $num)
    {
        return static::RU_MONTHS[$num + 1];
    }

    public static function getWeekdayString($index, $full = true)
    {
        $index = trim($index, '0');

        if ($full) {
            return static::$REAL_WEEK[$index]['full'];
        }

        return static::$REAL_WEEK[$index]['short'];
    }

    public static function getQuarter(int $timestamp)
    {
        $month = date('m', $timestamp);
        return (int)(($month + 2)/3);
    }

    public static function getQuarterString(int $timestamp)
    {
        $quarter = static::getQuarter($timestamp);
        return $quarter . ' кв. ' . date('Y', $timestamp) . ' г.';
    }

    public static function getQuarterFullString(int $timestamp)
    {
        $quarter = static::getQuarter($timestamp);
        return $quarter . ' квартал ' . date('Y', $timestamp) . ' г.';
    }

    public static function getYearsInterval($distance)
    {
        $year = date('Y', time());
        $last = $year - $distance;
        $result = [];
        for ($i = $year; $i > $last; --$i) {
            $result[$i] = $i;
        }

        return $result;
    }

    public static function formatTimestampRu($timestamp) 
    {
        // Создаем объект DateTime из timestamp
        $date = new \DateTime();
        $date->setTimestamp($timestamp);

        // Устанавливаем локаль и форматтер даты
        $formatter = new \IntlDateFormatter(
            'ru_RU', // Локаль
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            null,
            null,
            'd MMMM y, HH:mm' // Формат: 5 апреля 2025, 14:30
        );

        // Форматируем дату
        return $formatter->format($date);
    }

    public static function formatTimeDiffImproved($timestamp1, $timestamp2): string
    {
        $diffInSeconds = abs($timestamp2 - $timestamp1);

        $minutes = floor($diffInSeconds / 60);
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        $result = '';

        if ($hours > 0) {
            $result .= $hours . ' ' . self::getDeclension($hours, ['час', 'часа', 'часов']) . ' ';
        }

        if ($remainingMinutes > 0 || $hours == 0) {
            $result .= $remainingMinutes . ' ' . self::getDeclension($remainingMinutes, ['минута', 'минуты', 'минут']);
        }

        return trim($result);
    }

    public static function getDeclension($number, $words) 
    {
        $number = abs($number) % 100;
        $mod10 = $number % 10;

        if ($number > 10 && $number < 20) {
            return $words[2];
        }

        if ($mod10 > 1 && $mod10 < 5) {
            return $words[1];
        }

        if ($mod10 == 1) {
            return $words[0];
        }

        return $words[2];
    }
}
