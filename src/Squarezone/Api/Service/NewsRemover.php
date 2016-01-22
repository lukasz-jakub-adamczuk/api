<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Squarezone\Exception\SquarezoneException;

class NewsRemover extends NewsModifier
{
    /**
     * @var NewsProvider
     */
    private $newsProvider;

    /**
     * @var Connection
     */
    private $db;

    public function __construct(NewsProvider $newsProvider, Connection $db)
    {
        $this->newsProvider = $newsProvider;
        $this->db = $db;
    }

    public function delete($newsData)
    {
        $item = $this->newsProvider->get($newsData, $this->db);

        $id = $item['id_news'];

        if ($id) {
            $db->delete('news', array('id_news' => $id));
        } else {
            throw new SquarezoneException();
        }
    }
}
