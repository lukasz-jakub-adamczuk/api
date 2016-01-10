<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Squarezone\Exception\SquarezoneException;

class NewsRemover
{
    public function delete($id, Connection $db)
    {
        if ($id) {
            $db->delete('news', array('id_news' => $id));
        } else {
            throw new SquarezoneException();
        }
    }
}
