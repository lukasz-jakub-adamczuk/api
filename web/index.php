<?php
date_default_timezone_set('Europe/Warsaw');
setlocale(LC_ALL, 'pl_PL.UTF8');

// load config
if ($_SERVER['HTTP_HOST'] == 'api.squarezone.pl') {
	error_reporting(0);
	require_once '../config/production.php';
	$host = 'http://api.squarezone.pl/web';
} else {
	if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.1.108') {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		require_once '../config/local.php';
		$host = 'http://localhost/~ash/api/web';
	}
}

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
	'db.options' => $config
));


// $app['db']->fetchAll('SELECT * FROM table');
// print_r($news);

// $sql = "SELECT * FROM posts WHERE id = ?";
// $post = $app['db']->fetchAssoc($sql, array((int) $id));

// return  "<h1>{$post['title']}</h1>".
        // "<p>{$post['body']}</p>";


$app->get('/', function() use ($host) {
	$url = $host . '/index.php';

	$api = array(
		'links' => array(
			array(
				'rel' => 'news',
				'href' => $url . '/news'
			),
			// array(
			// 	'rel' => 'articles',
			// 	'href' => $url . '/articles'
			// )
		),
	);

	return json_encode($api);
});

$app->get('/news', function() use ($app) {
	// $news = $app['db']->fetchAll('SELECT * FROM news LIMIT 0,30');
	$news = $app['db']->fetchAll('SELECT id_news, title, slug, creation_date FROM news LIMIT 0,30');
	
	$html = '';
	foreach ($news as $item) {
		// $html .= '<p><a href="./news/'.$item['id_news'].'">' . $item['title'] . '</a></p>';
	}

	// return "<h1>Strona ostatnich newsow</h1>" . $html;

	$url = $host . '/index.php';

	$api = array(
		'links' => array(
			array(
				'rel' => 'next',
				'href' => $url . '/news?page=1&size=30'
			),
			// array(
			// 	'rel' => 'self',
			// 	'href' => $url . '/news{?page,size,sort}'
			// )
		),
		'content' => $news,
		'page' => array(
			'size' => 30,
			'totalElements' => '???',
			'totalPages' => '???',
			'number' => 0
		)
	);

	return json_encode($api);
})->method('GET|POST');

$app->get('/news/{id}', function($id) use ($app){
	$sql = "SELECT * FROM news WHERE id_news = ?";
	//$sql = "SELECT id_news, title, slug FROM news WHERE id_news = ?";
    $post = $app['db']->fetchAssoc($sql, array((int) $id));

    // return  "<h1>{$post['title']}</h1>".
            // "<div>{$post['markup']}</div>";
    $url = $host . '/index.php';

	$api = array(
		'links' => array(
			array(
				'rel' => 'self',
				'href' => $url . '/news/' . $id
			)
		),
		'news' => $post
	);

    return json_encode($api);
})->assert('id', '\d+');

$app->run();