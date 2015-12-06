<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

use Squarezone\SquarezoneException;

class NewsProvider
{
    public function get(Request $req, Connection $db)
    {
        $year = $req->get('year', false);
        $month = $req->get('month', false);
        $day = $req->get('day', false);
        $slug = $req->get('slug', false);

        if (empty($year) || empty($month) || empty($day) || empty($slug)) {
            throw new SquarezoneException();
        }

        $sql = 'SELECT n.id_news, n.title, n.slug, n.creation_date FROM news n';

        $whereParts = [];

        $whereParts[] = sprintf('YEAR(n.creation_date)="%s"', $year);
        $whereParts[] = sprintf('MONTH(n.creation_date)="%s"', $month);
        $whereParts[] = sprintf('DAY(n.creation_date)="%s"', $day);
        $whereParts[] = sprintf('n.slug="%s"', $slug);

        $sql .= ' WHERE ' . implode(' AND ', $whereParts);

        if ($result = $db->fetchAssoc($sql)) {
            return $result;
        }
        return false;
    }
}
