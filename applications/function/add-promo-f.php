
<?php

function connect() {
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'blitz';
    
    $mysqli = new mysqli($hostname, $username, $password, $dbname);
    
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    
    return $mysqli;
}

function addpromo($type, $name, $end_date, $description, $promotion_cover, $username) {

    $requiredFields = ['type', 'name', 'end_date', 'description', 'promotion_cover'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            return "Field '{$field}' is required.";
        }
    }
    
    $mysqli = connect();
    $args = func_get_args();

    $args = array_map(function($value) {
        return trim($value);
    }, $args);

    // foreach ($args as $value) {
    //     if (empty($value)) {
    //         return "All fields are required";
    //     }
    // }

    foreach ($args as $value) {
        if (preg_match("/([<|>])/", $value)) {
            return "<> characters are not allowed";
        }
    }
    $requiredFields = ['type', 'name', 'end_date', 'description', 'promotion_cover'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            return "Field '{$field}' is required.";
        }
    }

    $stmt = $mysqli->prepare("INSERT INTO promotions (type, name, end_date, description, promotion_cover, username) VALUES ( ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $type, $name, $end_date, $description, $promotion_cover, $username);
        $stmt->execute();
        if ($stmt->affected_rows != 1) {
            return "An error occurred. Please try again";
        } else {
            header("location: company-feed.php");
        }
	}
	?>