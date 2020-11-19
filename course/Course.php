<?php
class Course{

    // database connection and table name
    private $conn;
    private $table_name = "course_details";

    // course properties
    private $course_id;
    private $course_title;
    private $course_description;

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

    public function setCourseTitle($course_title)
    {
        $this->course_title=$course_title;

    }

    public function getCourseTitle(){

        return $this->course_title;
    }

    public function setCourseDescription($course_description)
    {
        $this->course_description=$course_description;

    }

    public function getCourseDescription(){

        return $this->course_description;
    }


    public function create(){

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                course_title=:title, course_description=:description";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->course_title=htmlspecialchars(strip_tags($this->course_title));
        $this->course_description=htmlspecialchars(strip_tags($this->course_description));

        // bind values
        $stmt->bindParam(":title", $this->course_title);
        $stmt->bindParam(":description", $this->course_description);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }


    // read courses
    function read(){

        // select all query
        $query = "SELECT
                course_id ,course_title, course_description
            FROM
                " . $this->table_name . " 
                
            ORDER BY
               course_id DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //read course from id
    function readOne(){

        // query to read single record
        $query = "SELECT
                   course_id ,course_title, course_description
            FROM
                " . $this->table_name . "  
            WHERE
               course_id = ?
            LIMIT
                0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of course id
        $stmt->bindParam(1, $this->course_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->course_id = $row['course_id'];
        $this->course_description = $row['course_description'];
        $this->course_title = $row['course_title'];

    }


}