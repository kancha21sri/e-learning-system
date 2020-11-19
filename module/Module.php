<?php
class Module{

    // database connection and table name
    private $conn;
    private $table_name = "module_details";

    // module properties
    private $module_id ;
    private $module_title;
    private $reading_material;
    private $module_deadline;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // define setters and getters
    public function setModuleId($module_id)
    {
        $this->module_id=$module_id;

    }

    public function getModuleId(){

        return $this->module_id;
    }

    public function setModuleTitle($module_title)
    {
        $this->module_title=$module_title;

    }

    public function getModuleTitle(){

        return $this->module_title;
    }

    public function setReadingMaterials($reading_materials)
    {
        $this->reading_material=$reading_materials;

    }

    public function getReadingMaterials(){

        return $this->reading_material;
    }

    public function setModuleDeadline($module_deadline)
    {
        $this->module_deadline=$module_deadline;

    }

    public function getModuleDeadline(){

        return $this->module_deadline;
    }


    public function create(){

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                module_title=:title, reading_material=:description,deadline=:deadline";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->module_title=htmlspecialchars(strip_tags($this->module_title));
        $this->reading_material=htmlspecialchars(strip_tags($this->reading_material));
        $this->module_deadline=htmlspecialchars(strip_tags($this->module_deadline));

        // bind values
        $stmt->bindParam(":title", $this->module_title);
        $stmt->bindParam(":description", $this->reading_material);
        $stmt->bindParam(":deadline", $this->module_deadline);
        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }


    // read modules
    function read(){

        // select all query
        $query = "SELECT
                module_id  ,module_title, reading_material,deadline
            FROM
                " . $this->table_name . " 
                
            ORDER BY
               module_id DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //read module from id
    function readOne(){

        // query to read single record
        $query = "SELECT
                   module_id  ,module_title, reading_material,deadline
            FROM
                " . $this->table_name . "  
            WHERE
               module_id = ?
            LIMIT
                0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of module id
        $stmt->bindParam(1, $this->module_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->module_id = $row['module_id'];
        $this->module_title = $row['module_title'];
        $this->reading_material = $row['reading_material'];
        $this->module_deadline= $row['deadline'];

    }


}
