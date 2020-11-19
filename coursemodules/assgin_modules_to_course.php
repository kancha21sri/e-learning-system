<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// get database connection
include_once '../config/Database.php';

// instantiate CourseModules object
include_once '../coursemodules/CourseModules.php';
include_once '../module/Module.php';
include_once '../course/Course.php';

$database = new Database();
$db = $database->getConnection();

$courseModule = new CourseModules($db);
$module=new Module($db);
$course= new Course($db);

// make sure data is not empty
if(!empty($_POST['course_id']) && !empty($_POST['module_id'])){

    // set  property values
    $courseModule->setModuleId($_POST['module_id']);
    $courseModule->setCourseId($_POST['course_id']);

    $module->setModuleId($_POST['module_id']);
    $course->setCourseId($_POST['course_id']);

    $module->readOne();
    $course->readOne();

    if(!empty($module->getModuleTitle()) && !empty($course->getCourseTitle())){



        if($courseModule->chekExistRecords()){

            echo json_encode(array("message" => "Already Assigned"));

        }else{

            // assgin to  course module
            if($courseModule->create()){

                // set response code - 201 created
                http_response_code(201);

                // tell the user
                echo json_encode(array("message" => "Module ".$_POST['module_id']." Assigned to ".$_POST['course_id']." course" ));
            } else{

                // set response code - 503 service unavailable
                http_response_code(503);

                // tell the user to assgin problem
                echo json_encode(array("message" => "Unable to assign module."));
            }


        }


    }else{

        echo json_encode(array("message" => "Unable to assign module.given course id or module id not in our system"));


    }


} else{

    // set response code - 400 bad request
    http_response_code(400);

    echo json_encode(array("message" => "Unable to assign module.Please add the course id and module id"));
}
