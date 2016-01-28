<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
// use Symfony\Component\HttpFoundation\Request;

use Squarezone\Exception\NotFoundException;
use Squarezone\Exception\SquarezoneException;

class NewsProvider
{
    public function get(array $fields, Connection $db)
    {
        if (empty($fields['year']) || empty($fields['month']) || empty($fields['day']) || empty($fields['slug'])) {
            throw new SquarezoneException();
        }

        $sql = 'SELECT n.id_news, n.title, n.slug, n.creation_date FROM news n';

        $whereParts = [];

        $whereParts[] = sprintf('YEAR(n.creation_date)="%s"', $fields['year']);
        $whereParts[] = sprintf('MONTH(n.creation_date)="%s"', $fields['month']);
        $whereParts[] = sprintf('DAY(n.creation_date)="%s"', $fields['day']);
        $whereParts[] = sprintf('n.slug="%s"', $fields['slug']);

        $sql .= ' WHERE ' . implode(' AND ', $whereParts);

        if ($result = $db->fetchAssoc($sql)) {
            return $result;
        } else {
            throw new NotFoundException();
        }
    }
}
