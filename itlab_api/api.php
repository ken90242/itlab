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

$app->get('/equipment', function () use ($app,$db){
    //User Select[all]

    $equipments = array();
    foreach ($db->equipment() as $data) {
        $equipments[]  = array(
            "id" => $data["id"],
            "name" => $data["name"],
            "class" => $data["class"],
            "status" => $data["status"],
            "current_owner" => $data["current_owner"],
            "addition" => $data["addition"]
        );
    }
    $app->response()->header("Content-Type", "application/json");
    echo json_encode($equipments);
});

$app->get('/trade', function () use ($app,$db){
    //User Select[all]
    $trade = $db->trade();

    if(isset($_GET['u_id'])) {
        $trade->where("u_id", $_GET['u_id']);
    }
    $trades = array();
    foreach ( $trade as $data) {
        $trades[]  = array(
            "id" => $data["id"],
            "u_id" => $data["u_id"],
            "e_id" => $data["e_id"],
            "time" => $data["time"],
            "deadline_time" => $data["deadline_time"],
            "delaytimes" => $data["delaytimes"],
            "return_time" => $data["return_time"],
            "t_status" => $data["t_status"],
            "handler" => $data["handler"],
            "e_addition" => $data["e_addition"],
            "e_addition_class" => $data["e_addition_class"],
        );
    }
    $app->response()->header("Content-Type", "application/json");
    echo json_encode($trades);
});

$app->get('/user/:id', function ($id) use ($app,$db) {
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
            "error" => true,
            "message" => "User ID $id does not exist"
        ));
    }
});

$app->get('/equipment/:id', function ($id) use ($app,$db) {
    $equipment = $db->equipment()->where("id", $id);
    if ($data = $equipment->fetch()) {
        echo json_encode(array(
            "id" => $data["id"],
            "name" => $data["name"],
            "class" => $data["class"],
            "status" => $data["status"],
            "current_owner" => $data["current_owner"],
            "addition" => $data["addition"]
        ));
    } else {
        echo json_encode(array(
            "error" => true,
            "message" => "Equipment ID $id does not exist"
        ));
    }
});

$app->get('/trade/:id', function ($id) use ($app,$db) {
    $trade = $db->trade()->where("id", $id);
    if ($data = $trade->fetch()) {
        echo json_encode(array(
            "id" => $data["id"],
            "u_id" => $data["u_id"],
            "e_id" => $data["e_id"],
            "time" => $data["time"],
            "deadline_time" => $data["deadline_time"],
            "delaytimes" => $data["delaytimes"],
            "return_time" => $data["return_time"],
            "t_status" => $data["t_status"],
            "handler" => $data["handler"],
            "e_addition" => $data["e_addition"],
            "e_addition_class" => $data["e_addition_class"],
        ));
    } else {
        echo json_encode(array(
            "error" => true,
            "message" => "Equipment ID $id does not exist"
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
            "error" => !(bool)$result,
            "message" => "User updated successfully"
            ));
    }
    else{
        echo json_encode(array(
            "error" => true,
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
            "error" => false,
            "message" => "User deleted successfully"
        ));
    }
    else{
        echo json_encode(array(
            "error" => true,
            "message" => "User id $id does not exist"
        ));
    }
});

$app->run();
?>