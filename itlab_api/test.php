<?php
// index.php

require 'vendor/autoload.php';

$app = new \Slim\Slim();

// $app->group('', function(){
//     echo '<h1>Hello World</h1>';
// 	$app->get('/hello/:name', function ($name) {
// 	    echo "Hello, $name";
// 	});
// });
$app->group('/api', function () use ($app) {
	echo '/api';
    // Library group
    $app->group('/library', function () use ($app) {
    	echo '/lib';
        // Get book with ID
        $app->get('/books/:id', function ($id) {
        	echo '/book, $id';
        });

        // Update book with ID
        $app->put('/books/:id', function ($id) {

        });

        // Delete book with ID
        $app->delete('/books/:id', function ($id) {

        });

    });

});

$app->run();
?>