<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// get database connection
include_once '../config/Database.php';

// instantiate course object
include_once '../course/Course.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare course object
$course = new Course($db);

// set ID property of record to read
$course_id= isset($_GET['id']) ? $_GET['id'] : die();

$course->setCourseId($course_id);

// read the details of course to be viewd
$course->readOne();

if( $course->getCourseTitle()!=null){
    // create array
    $course_arr = array(
        "course_id " => $course->getCourseId(),
        "course_title" =>$course->getCourseTitle(),
        "course_description" => $course->getCourseDescription()

    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($course_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user course does not exist
    echo json_encode(array("message" => "Course does not exist."));
}
