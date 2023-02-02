<?php


namespace Services;


class PageServices
{
    public static function generatePagination(int $curPage, int $maxPage): ?array
    {
        $pagination = [];
        $prevPage = $curPage - 1;
        $nextPage = $curPage + 1;

        if($maxPage !== 1)
        {
            if($curPage != 1)
            {
                $pagination[] = array(
                    'text' => '<',
                    'ref' => $curPage - 1,
                );
                $pagination[] = array(
                    'text' => '1',
                    'ref' => 1,
                );
            }
            if($prevPage > 1)
            {
                if($prevPage > 2)
                {
                    $pagination[] = array(
                        'text' => '...',
                        'ref' => null,
                    );
                }
                $pagination[] = array(
                    'text' => $prevPage,
                    'ref' => $prevPage,
                );
            }
            $pagination[] = array(
                'text' => $curPage,
                'ref' => null,
            );
            if($maxPage-$curPage > 0)
            {
                if($maxPage-$curPage > 1)
                {
                    $pagination[] = array(
                        'text' => $nextPage,
                        'ref' => $nextPage,);
                    if($maxPage-$curPage > 2)
                    {
                        $pagination[] = array(
                            'text' => '...',
                            'ref' => null,
                            );
                    }
                }
                $pagination[] = array(
                    'text' => $maxPage,
                    'ref' => $maxPage,
                );
                $pagination[] = array(
                    'text' => '>',
                    'ref' => $curPage + 1,
                );
            }
        }
        else
        {
            $pagination[] = array(
                'text' => '1',
                'ref' => ' '
            );
        }
        return $pagination;
    }
}