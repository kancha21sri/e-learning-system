<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// get database connection
include_once '../config/Database.php';

// instantiate module object
include_once '../module/Module.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare module object
$module = new Module($db);

// set ID property of record to read
$module_id= isset($_GET['id']) ? $_GET['id'] : die();

$module->setModuleId($module_id);

// read the details of module to be viewd
$module->readOne();

if( $module->getModuleTitle()!=null){
    // create array
    $module_arr = array(
        "module_id" => $module->getModuleId(),
        "module_title" =>$module->getModuleTitle(),
        "reading_material" => $module->getReadingMaterials(),
        "deadline"=>$module->getModuleDeadline()

    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($module_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user module does not exist
    echo json_encode(array("message" => "module does not exist."));
}
