<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Squarezone\Exception\SquarezoneException;

class ArticleRemover
{
    public function delete($id, Connection $db)
    {
        if ($id) {
            $db->delete('article', ['id_article' => $id]);
        } else {
            throw new SquarezoneException();
        }
    }
}
