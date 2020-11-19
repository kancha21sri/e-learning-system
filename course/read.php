<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// get database connection
include_once '../config/Database.php';

// instantiate course object
include_once '../course/Course.php';

$database = new Database();
$db = $database->getConnection();

$course = new Course($db);

// query course
$stmt = $course->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // course array
    $course_arr=array();
    $course_arr["records"]=array();

    // retrieve our course table contents
    // fetch() is faster than fetchAll()
    //
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $course_item=array(
            "course_id " => $row['course_id'],
            "course_title" =>$row['course_title'] ,
            "course_description" => $row['course_description']

        );

        array_push($course_arr["records"], $course_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show course data in json format
    echo json_encode($course_arr);
}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no course found
    echo json_encode(
        array("message" => "No course found.")
    );


}
