<?php

namespace Squarezone\Api\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

use Squarezone\Exception\SquarezoneException;

class ArticleCreator
{
    public function create(Request $request, Connection $db)
    {
    	$title = $request->get('title', false);

    	if (empty($title)) {
        	throw new SquarezoneException();
        }

        // query
    }
}
