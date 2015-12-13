<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

use Squarezone\Exception\SquarezoneException;

class ArticleRemover
{
    public function delete($id, Connection $db)
    {
        if ($id) {
            $article = $db->delete('article', array('id_article' => $id));
        } else {
            throw new SquarezoneException();
        }
    }
}
