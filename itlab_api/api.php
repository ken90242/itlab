<?php
header('Content-type: text/html;charset=utf-8'); 
require 'lib/slim/vendor/autoload.php';
require 'lib/notorm/NotORM.php';

$app = new \Slim\Slim();
$dsn='mysql:dbname=itlab;host=localhost:8889';
$pdo = new PDO($dsn, 'root', 'root');
$itlab = new NotORM($pdo);
// $itlab->debug = true;
$itlab->exec("SET names 'utf8'");

$books = $itlab->user();

foreach ($books as $book) {
	echo "{$book["id"]} {$book["name"]} {$book["email"]}<br>";
}
$data = array(
    "id" => "099129301",
    "name" => "王大明"
);
echo $result = $books->insert($data);
// print_r($itlab);



$app->get('/', function()
{
    echo '<h1>Helloa World</h1>';
});
// $app->get('/hello/:name', function ($name) {
//     echo "Hello, $name";
// });
$app->group('/api', function () use ($app){
    // Library group
    $app->group('/library', function () use ($app){
        // Get book with ID
        $app->get('/books/:id', function ($id) {
        	echo "/book {$id}";
        	// echo $_GET["sort"];
        });

        // Update book with ID
        $app->put('/books/:id', function ($id) {
        	echo '4';
        });

        // Delete book with ID
        $app->delete('/books/:id', function ($id) {
        	echo '5';
        });

    });

});

$app->run();
?>