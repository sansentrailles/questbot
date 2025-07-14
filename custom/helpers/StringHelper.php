<?php

declare(strict_types=1);

namespace app\custom\helpers;

class StringHelper
{
    public static function generateString($length = 6, $prefix = '', $upperCase = false)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = \strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        $randomString = $prefix . $randomString;

        if ($upperCase) {
            $randomString = mb_strtoupper($randomString);
        }

        return $randomString;
    }

    public static function ucfirst($text)
    {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }

    public static function lcfirst($text)
    {
        return mb_strtolower(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }

    public static function explodeByCapitalLetter($str): array
    {
        $res = [];
        preg_match_all('/[A-Z][^A-Z]*?/Us', $str, $res);

        return $res[0];
    }

    public static function camelCase($str)
    {
        $parts = self::explodeByCapitalLetter($str);
        $first = mb_strtolower(array_shift($parts));
        $tail = array_map(static fn ($item) => self::ucfirst($item), $parts);

        return $first . implode('', $tail);
    }

    public static function snakeCase($str, $toLower = true)
    {
        $parts = self::explodeByCapitalLetter($str);

        $result = implode('_', $parts);
        if ($toLower) {
            $result = mb_strtolower($result);
        }

        return $result;
    }

    public static function snakeToCamelCase($str, $firstLower = false)
    {
        $parts = explode('_', $str);

        $result =  implode('', array_map(static fn ($item) => self::ucfirst($item), $parts));

        if ($firstLower) {
            $result = self::lcfirst($result);
        }

        return $result;
    }

    public static function camelToKebabCase($str, $toLower = true)
    {
        $parts = self::explodeByCapitalLetter($str);
        if (\count($parts) === 0) {
            $result = $str;
        } else {
            $result = implode('-', $parts);
        }

        if ($toLower) {
            $result = mb_strtolower($result);
        }

        return $result;
    }

    public static function camelToSnakeCase($str)
    {
        $parts = self::explodeByCapitalLetter($str);
        if (\count($parts) === 0) {
            return mb_strtolower($str);
        }

        return mb_strtolower(implode('_', $parts));
    }

    public static function mb_str_replace($search, $replace, $string)
    {
        $charset = mb_detect_encoding($string);

        $unicodeString = iconv($charset, "UTF-8", $string);
        
        return str_replace($search, $replace, $unicodeString);
    }

    // public static function mb_replace($search, $replace, $subject, &$count=0)
    // {
    //     if (!\is_array($search) && \is_array($replace)) {
    //         return false;
    //     }
    //     if (\is_array($subject)) {
    //         // call mb_replace for each single string in $subject
    //         foreach ($subject as &$string) {
    //             $string = &mb_replace($search, $replace, $string, $c);
    //             $count += $c;
    //         }
    //     } elseif (\is_array($search)) {
    //         if (!\is_array($replace)) {
    //             foreach ($search as &$string) {
    //                 $subject = mb_replace($string, $replace, $subject, $c);
    //                 $count += $c;
    //             }
    //         } else {
    //             $n = max(\count($search), \count($replace));
    //             while ($n--) {
    //                 $subject = mb_replace(current($search), current($replace), $subject, $c);
    //                 $count += $c;
    //                 next($search);
    //                 next($replace);
    //             }
    //         }
    //     } else {
    //         $parts = mb_split(preg_quote($search), $subject);
    //         $count = \count($parts)-1;
    //         $subject = implode($replace, $parts);
    //     }
    //     return $subject;
    // }

    public static function toRu($value)
    {
        $converter = [
            'f' => 'а', ',' => 'б', 'd' => 'в', 'u' => 'г', 'l' => 'д', 't' => 'е', '`' => 'ё',
            ';' => 'ж', 'p' => 'з', 'b' => 'и', 'q' => 'й', 'r' => 'к', 'k' => 'л', 'v' => 'м',
            'y' => 'н', 'j' => 'о', 'g' => 'п', 'h' => 'р', 'c' => 'с', 'n' => 'т', 'e' => 'у',
            'a' => 'ф', '[' => 'х', 'w' => 'ц', 'x' => 'ч', 'i' => 'ш', 'o' => 'щ', 'm' => 'ь',
            's' => 'ы', ']' => 'ъ', "'" => 'э', '.' => 'ю', 'z' => 'я',

            'F' => 'А', '<' => 'Б', 'D' => 'В', 'U' => 'Г', 'L' => 'Д', 'T' => 'Е', '~' => 'Ё',
            ':' => 'Ж', 'P' => 'З', 'B' => 'И', 'Q' => 'Й', 'R' => 'К', 'K' => 'Л', 'V' => 'М',
            'Y' => 'Н', 'J' => 'О', 'G' => 'П', 'H' => 'Р', 'C' => 'С', 'N' => 'Т', 'E' => 'У',
            'A' => 'Ф', '{' => 'Х', 'W' => 'Ц', 'X' => 'Ч', 'I' => 'Ш', 'O' => 'Щ', 'M' => 'Ь',
            'S' => 'Ы', '}' => 'Ъ', '"' => 'Э', '>' => 'Ю', 'Z' => 'Я',

            '@' => '"', '#' => '№', '$' => ';', '^' => ':', '&' => '?', '/' => '.', '?' => ',',
        ];

        return strtr($value, $converter);
    }

    public static function toEn($value)
    {
        $converter = [
            'а' => 'f', 'б' => ',', 'в' => 'd', 'г' => 'u', 'д' => 'l', 'е' => 't', 'ё' => '`',
            'ж' => ';', 'з' => 'p', 'и' => 'b', 'й' => 'q', 'к' => 'r', 'л' => 'k', 'м' => 'v',
            'н' => 'y', 'о' => 'j', 'п' => 'g', 'р' => 'h', 'с' => 'c', 'т' => 'n', 'у' => 'e',
            'ф' => 'a', 'х' => '[', 'ц' => 'w', 'ч' => 'x', 'ш' => 'i', 'щ' => 'o', 'ь' => 'm',
            'ы' => 's', 'ъ' => ']', 'э' => "'", 'ю' => '.', 'я' => 'z',

            'А' => 'F', 'Б' => '<', 'В' => 'D', 'Г' => 'U', 'Д' => 'L', 'Е' => 'T', 'Ё' => '~',
            'Ж' => ':', 'З' => 'P', 'И' => 'B', 'Й' => 'Q', 'К' => 'R', 'Л' => 'K', 'М' => 'V',
            'Н' => 'Y', 'О' => 'J', 'П' => 'G', 'Р' => 'H', 'С' => 'C', 'Т' => 'N', 'У' => 'E',
            'Ф' => 'A', 'Х' => '{', 'Ц' => 'W', 'Ч' => 'X', 'Ш' => 'I', 'Щ' => 'O', 'Ь' => 'M',
            'Ы' => 'S', 'Ъ' => '}', 'Э' => '"', 'Ю' => '>', 'Я' => 'Z',

            '"' => '@', '№' => '#', ';' => '$', ':' => '^', '?' => '&', '.' => '/', ',' => '?',
        ];

        return strtr($value, $converter);
    }

    public static function transliterate($textcyr = null, $textlat = null)
    {
        $cyr = [
            'ж', 'ч', 'щ', 'ш', 'ю', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я',
            'Ж', 'Ч', 'Щ', 'Ш', 'Ю', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Я',
        ];

        $lat = [
            'zh', 'ch', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'x', 'q',
            'Zh', 'Ch', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', 'Y', 'X', 'Q',
        ];

        return str_replace($cyr, $lat, $textcyr);
        if ($textcyr) {
            return str_replace($cyr, $lat, $textcyr);
        }
        if ($textlat) {
            return str_replace($lat, $cyr, $textlat);
        }
        return null;
    }

    public static function escapeMarkdown($text) 
    {
        $specialChars = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        foreach ($specialChars as $char) {
            $text = str_replace($char, '\\' . $char, $text);
        }
        return $text;
    }

    public static function numberToEmojiDigits($number) {
    // Маппинг цифр к эмодзи
    $emojiDigits = [
        '0' => '0️⃣',
        '1' => '1️⃣',
        '2' => '2️⃣',
        '3' => '3️⃣',
        '4' => '4️⃣',
        '5' => '5️⃣',
        '6' => '6️⃣',
        '7' => '7️⃣',
        '8' => '8️⃣',
        '9' => '9️⃣'
    ];

    // Преобразуем число в строку
    $numberStr = (string)$number;

    // Заменяем каждую цифру на эмодзи
    $result = '';
    for ($i = 0; $i < strlen($numberStr); $i++) {
        $digit = $numberStr[$i];
        if (isset($emojiDigits[$digit])) {
            $result .= $emojiDigits[$digit];
        } else {
            $result .= '?'; // Если символ не цифра — ставим знак вопроса
        }
    }

    return $result;
}

    public static function getEmojiNum($num)
    {
        $nums = ["1️⃣", "2️⃣", "3️⃣", "4️⃣", "5️⃣", "6️⃣", "7️⃣", "8️⃣", "9️⃣"];

        if (isset($nums[$num])) {
            return $nums[$num];
        }

        return '';
    }

    public static function generateUuidV4(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
}

}
