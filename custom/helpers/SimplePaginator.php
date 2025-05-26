<?php

declare(strict_types=1);

namespace app\custom\helpers;

class SimplePaginator
{
    /**
     * Cut list into pages.
     *
     * @param array list
     * @param int limit
     * @param mixed $limit
     */
    public static function pages(array $list, $limit = 0): array
    {
        if ($limit > 0) {
            return array_chunk($list, $limit);
        }

        return $list;
    }

    public static function pageItems(array $list, $limit = 1, $page = 1): array
    {
        $pages = self::pages($list, $limit);
        $count = \count($list);

        $isLast = false;
        if (($page * $limit) >= $count) {
            $isLast = true;
        }

        $pageIndex = $page - 1;
        $actualPage = $pages[$pageIndex] ?? [];

        return [
            'list' => $actualPage,
            'isLast' => $isLast,
            'page' => $page,
            'count' => $count,
        ];
    }
}
