<?php
class CourseModules{

    // database connection and table name
    private $conn;
    private $table_name = "course_has_modules";

    // course properties
    private $course_id;
    private $module_id;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // define setters and getters
    public function setCourseId($course_id)
    {
        $this->course_id=$course_id;

    }

    public function getCourseId(){

        return $this->course_id;
    }

    public function setModuleId($module_id)
    {
        $this->module_id=$module_id;

    }

    public function getModuleId(){

        return $this->module_id;
    }



    public function create(){

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                course_id=:course_id , module_id =:module_id";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->course_id=htmlspecialchars(strip_tags($this->course_id));
        $this->module_id=htmlspecialchars(strip_tags($this->module_id));

        // bind values
        $stmt->bindParam(":course_id", $this->course_id);
        $stmt->bindParam(":module_id", $this->module_id);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }


    //check the existing records
    function chekExistRecords(){

        // query to read single record
        $query = "SELECT
                   id   ,course_id , module_id 
            FROM
                " . $this->table_name . "  
            WHERE
               module_id = ? and course_id = ?
            LIMIT
                0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of module id
        $stmt->bindParam(1, $this->module_id);
        $stmt->bindParam(2, $this->course_id);

        // execute query
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }











}