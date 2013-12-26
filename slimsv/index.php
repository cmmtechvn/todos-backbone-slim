<?php

/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'RedBean/rb.php';
require 'Slim/Slim.php';
require 'Slim/Middleware.php';
require 'Slim/Middleware/SessionCookie.php';
\Slim\Slim::registerAutoloader();
R::setup('mysql:host=localhost;dbname=todo', 'root', '');
R::freeze(true);
/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */
// POST route
$app->post(
	'/post', function () {
		echo 'This is a POST route';
	}
);

// PUT route
$app->put(
	'/todos/:id', function ($id) use ($app) {
		$request = json_decode($app->request()->getBody());			
		$todo = R::load('todos', $id);		
		$todo->title = $request->title;
		$todo->completed = $request->completed;
		$id = R::store($todo);
		$app->response()->header('Content-Type', 'application/json');	
		echo json_encode($id);
	}
);

// DELETE route
$app->delete(
	'/todos/:id', function ($id) use ($app) {
		$todo = R::load('todos', $id);
        R::trash( $todo );
	}
);

$app->get('/todos/completed', function () use ($app) {
	$app->response()->header('Content-Type', 'application/json');
	$todos = R::find('todos', ' completed = ? ', array(1));
	echo json_encode(R::exportAll($todos));
});

$app->get('/todos', function () use ($app) {
	$app->response()->header('Content-Type', 'application/json');
	$todos = R::findAll('todos', ' ORDER BY id DESC ');
	$result = R::exportAll($todos);
    foreach ($result as $k => $v) {
        $result[$k]['completed'] = (boolean) $v['completed']; 
    }        
	echo json_encode($result);
});
$app->get('/todos/maxid', function () use ($app) {
	$app->response()->header('Content-Type', 'application/json');
	$result = R::$f->begin()->addSQL(' SELECT max(id) as maxid ')->from('todos')->get('row'); 
	if ($result['maxid'] === null) {
		$result['maxid'] = 0;
	}
	echo json_encode($result);
});
$app->get('/todos/:id', function ($id) use ($app) {
	$app->response()->header('Content-Type', 'application/json');
	$todo = R::load('todos', $id);
    $result = R::exportAll($todo);
    foreach ($result as $k => $v) {
        $result[$k]['completed'] = (boolean) $v['completed']; 
    }        
	echo json_encode($result);
});

$app->post('/todos', function () {
	$app = \Slim\Slim::getInstance();
	$request = json_decode($app->request()->getBody());	
	$todo = R::dispense('todos');
    //$todo->id = $request->id;
	
    $todo->title = $request->title;
	$id = R::store($todo);
	$app->response()->header('Content-Type', 'application/json');	
	echo json_encode($id);
});



/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
