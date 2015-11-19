<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

class NewsListProvider
{
	const SIZE = 25;
	
    public function get(Request $req, Connection $db)
    {
        $year = $req->get('year', false);
        $month = $req->get('month', false);
        $day = $req->get('day', false);
        $slug = $req->get('slug', false);

        // pagination
        $page = $req->get('page', 1);
        $size = $req->get('size', 25);

        // query
        $sql = 'SELECT id_news, title, slug, creation_date FROM news';
        // $sql = '...';

        $whereParts = [];

        if ($year) {
            $whereParts[] = sprintf('YEAR(creation_date)="%s"', $year);
            if ($month) {
                $whereParts[] = sprintf('MONTH(creation_date)="%s"', $month);
                if ($day && $slug) {
                    $whereParts[] = sprintf('DAY(creation_date)="%s"', $month);
                    $whereParts[] = sprintf('slug="%s"', $slug);
                }
            }

            $sql .= ' WHERE ' . implode(' AND ', $whereParts);
        } else {
            $sql .= ' LIMIT ' . (($page-1)*$size) . ',' . ($page*$size);
            // $sql .= ' LIMIT 0,25';
            // $sql .= ' LIMIT '.$page.','.$size.'';
        }

        return $db->fetchAll($sql);
    }
}
