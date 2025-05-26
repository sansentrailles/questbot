<?php

declare(strict_types=1);

namespace app\custom\helpers;

class SearchHelper
{
    public static function fullTextWildcards($term)
    {
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        if ($term === '') {
            $searchTerm = $term . '*';
        } else {
            $words = explode(' ', $term);

            foreach ($words as $key => $word) {
                /**
                 * applying + operator (required word) only big words
                 * because smaller ones are note indexed by mysql.
                 */
                if (\strlen($word) >= 3) {
                    $words[$key] = '+' . $word . '*';
                }
            }

            $searchTerm = implode(' ', $words);
        }

        return $searchTerm;
    }
}
