<?php
header('Content-type: text/html;charset=utf-8'); 
require 'lib/slim/vendor/autoload.php';
require 'lib/notorm/NotORM.php';

$app = new \Slim\Slim();
$dsn='mysql:dbname=itlab;host=localhost:8889';
$pdo = new PDO($dsn, 'root', 'root');
$db = new NotORM($pdo);
$itlab->debug = true;
$db->exec("SET names 'utf8'");

// $data = array(
//     "id" => "099129301",
//     "name" => "王大明"
// );
// echo $result = $books->insert($data)

/**
 * 
 *
 *
 *
 *
 **/



$app->get('/user', function () use ($app,$db){
    //User Select[all]

    $users = array();
    foreach ($db->user() as $data) {
        $users[]  = array(
            "id" => $data["id"],
            "name" => $data["name"],
            "email" => $data["email"],
            "department" => $data["department"],
            "phone" => $data["phone"],
            "blacklisted" => $data["blacklisted"]
        );
    }
    $app->response()->header("Content-Type", "application/json");
    echo json_encode($users);
    // echo $_GET["aa"];
});

$app->get('/user/:id', function ($id) use ($app,$db) {
    //User Select[specific]

    $user = $db->user()->where("id", $id);
    if ($data = $user->fetch()) {
        echo json_encode(array(
            "id" => $data["id"],
            "name" => $data["name"],
            "email" => $data["email"],
            "department" => $data["department"],
            "phone" => $data["phone"],
            "blacklisted" => $data["blacklisted"]
            ));
    } else {
        echo json_encode(array(
            "status" => false,
            "message" => "User ID $id does not exist"
        ));
    }
});

$app->post("/user", function () use($app, $db) {
    //User Insert
    $app->response()->header("Content-Type", "application/json");
    $input_data = $app->request()->post();
    $result = $db->$user->insert($input_data);
    echo json_encode(array("id" => $result["id"]));
});

$app->put("/user/:id", function ($id) use ($app, $db) {
    //User Update
    $app->response()->header("Content-Type", "application/json");

    $user = $db->user()->where("id", $id);

    if ($user->fetch()) {
        $input_data = $app->request()->put();
        $result = $user->update($input_data);
        echo json_encode(array(
            "status" => (bool)$result,
            "message" => "User updated successfully"
            ));
    }
    else{
        echo json_encode(array(
            "status" => false,
            "message" => "User id $id does not exist"
        ));
    }
});


$app->delete("/user/:id", function ($id) use($app, $db) {
    //User Delete
    $app->response()->header("Content-Type", "application/json");
    $data = $db->user()->where("id", $id);
    if ($data->fetch()) {
        $result = $data->delete();
        echo json_encode(array(
            "status" => true,
            "message" => "User deleted successfully"
        ));
    }
    else{
        echo json_encode(array(
            "status" => false,
            "message" => "User id $id does not exist"
        ));
    }
});

$app->run();
?>