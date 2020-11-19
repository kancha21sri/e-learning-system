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

// make sure data is not empty
if(!empty($_POST['title'])){

    // set  property values
    $course->setCourseTitle($_POST['title']);
    $course->setCourseDescription($_POST['description']);

    // create the course
    if($course->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Course was created."));
    } else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create course."));
    }
} else{

    // set response code - 400 bad request
    http_response_code(400);

    echo json_encode(array("message" => "Unable to create course.Please add the course Title"));
}
