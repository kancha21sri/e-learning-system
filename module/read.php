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

$module= new Module($db);

// query module
$stmt = $module->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // module array
    $module_arr=array();
    $module_arr["records"]=array();

    // retrieve our module table contents
    // fetch() is faster than fetchAll()
    //
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $module_item=array(
            "module_id  " => $row['module_id'],
            "module_title" =>$row['module_title'] ,
            "reading_material" => $row['reading_material'],
            "deadline"=> $row['deadline']

        );

        array_push($module_arr["records"], $module_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show module data in json format
    echo json_encode($module_arr);
}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no module found
    echo json_encode(
        array("message" => "No module found.")
    );


}