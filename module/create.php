<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// get database connection
include_once '../config/Database.php';

// instantiate module object
include_once '../module/Module.php';

$database = new Database();
$db = $database->getConnection();

$module = new Module($db);

// make sure data is not empty
if(!empty($_POST['title']) && !empty($_POST['deadline'])){

    // set  property values
    $module->setModuleTitle($_POST['title']);
    $module->setModuleDeadline($_POST['deadline']);
    $module->setReadingMaterials($_POST['materials']);


    if(((string) (int) $_POST['deadline'] ===$_POST['deadline']) && ($_POST['deadline'] <= PHP_INT_MAX) && ($_POST['deadline'] >= ~PHP_INT_MAX)){

        // create the module
        if($module->create()){

            // set response code - 201 created
            http_response_code(201);

            // tell the user
            echo json_encode(array("message" => "Module was created."));
        } else{

            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the user
            echo json_encode(array("message" => "Unable to create Module."));
        }

    }else{

        echo json_encode(array("message" => "Unable to create Module. Please enter the valid date for deadline"));


    }


} else{

    // set response code - 400 bad request
    http_response_code(400);

    echo json_encode(array("message" => "Unable to create Module. For Create a new Module  You need to add  module title and deadline"));
}


