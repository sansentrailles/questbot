<?php

declare(strict_types=1);

namespace app\custom\helpers;

/**
 * A set of methods used for working with phones.
 *
 *  @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class PhoneHelper
{
    public static function clearPhone($phone)
    {
        return preg_replace('~\\D~', '', $phone);
    }

    public static function skipCountryCode($phone)
    {
        return substr($phone, 1, \strlen($phone) - 1);
    }

    public static function sanitizePhone($value)
    {
        $value = preg_replace('~\\D~', '', $value);
        if (\strlen($value) === 11 && $value[0] === 7) {
            return substr($value, 1);
        }

        return $value;
    }

    public static function getSpacePhone($phone)
    {
        return '8 ' . substr($phone, 1, 3) .
                ' ' . substr($phone, 4, 3) .
                ' ' . substr($phone, 7, 2) .
                ' ' . substr($phone, 9, 2);
    }

    public static function getSpacePhoneAr($phone)
    {
        return substr($phone, 0, 4) .
                ' ' . substr($phone, 4, 2) .
                ' ' . substr($phone, 6, 3) .
                ' ' . substr($phone, 9, 2) .
                ' ' . substr($phone, 11, 2);
    }

    public static function getPhoneForCalling($phone, $skipFirst = false)
    {
        $phone = self::sanitizePhone($phone);
        if ($skipFirst) {
            $phone = self::skipCountryCode($phone);
        }

        return '+7' . $phone;
    }
}
