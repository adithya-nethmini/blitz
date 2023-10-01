
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

function addoffer($offer_cover, $type, $name, $end_date, $amount, $username, $offer_code) {

    $requiredFields = ['offer_cover', 'type', 'name', 'end_date', 'amount', 'offer_code'];
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
    $requiredFields = ['offer_cover', 'type', 'name', 'end_date', 'amount', 'offer_code'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            return "Field '{$field}' is required.";
        }
    }

    $stmt = $mysqli->prepare("INSERT INTO offers (offer_cover, type, name, end_date, amount, username, offer_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $offer_cover, $type, $name, $end_date, $amount, $username, $offer_code);
        $stmt->execute();
        if ($stmt->affected_rows != 1) {
            return "An error occurred. Please try again";
        } else {
            header("location: company-feed.php");
        }


    //reading the package
    }
function fetchPackageLimits($user) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT package FROM partner_company WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['package'];
    } else {
        return false; // User not found or package not defined
    }
}

// calulating current offer count

function fetchOfferCount($user) {
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT p.package, COUNT(o.id) AS count FROM `offers` AS o JOIN partner_company AS p ON o.username = p.username WHERE o.username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

    // $username = $_GET['username'] ; // Retrieve partner company username from the session

    // $stmt = $mysqli->prepare("INSERT INTO offers (offer_cover, type, name, end_date, amount, username, offer_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // if (!$stmt) {
    //     return "Error preparing statement: " . $mysqli->error;
    // }

    // $stmt->bind_param("ssssiss", $offer_cover, $type, $name, $end_date, $amount, $username, $offer_code);
    // $stmt->execute();

    // if ($stmt->affected_rows != 1) {
    //     echo 'Error: ' . $mysqli->error();
    // } else {
    //     return "Offer added successfully";
    //     header('location : company-feed.php');
    // }



// function addoffer($offer_cover, $type, $name, $end_date, $amount, $offer_code) {
//     // Check if the partner company username is stored in the session
//     if (!isset($_SESSION['pcompany_user'])) {
//         return "Partner company username not found in session.";
//     }
  
//     // Get the partner company username from the session
//     $username = $_SESSION['pcompany_user'];

//     $mysqli = connect();
//     if (!$mysqli) {
//         return "Failed to connect to the database.";
//     }

//     $stmt = $mysqli->prepare("INSERT INTO offers(offer_cover, type, name, end_date, amount, username, offer_code) VALUES(?,?,?,?,?,?,?)");
//     if (!$stmt) {
//         $error = $mysqli->error;
//         $mysqli->close();
//         return "Failed to prepare the SQL statement: " . $error;
//     }

//     $stmt->bind_param("bsssiis", $offer_cover, $type, $name, $end_date, $amount, $username, $offer_code);
//     $result = $stmt->execute();

//     if (!$result) {
//         $error = $mysqli->error;
//         $stmt->close();
//         $mysqli->close();
//         return "An error occurred while inserting the offer: " . $error;
//     }

//     $stmt->close();
//     $mysqli->close();

//     // Offer added successfully
//     $_SESSION["add"] = "Offer added successfully";
//     header("location: ../partner_company/company-feed.php");
//     exit();
// }





//include "config.php";
// function addoffer($offer_cover, $type, $name, $end_date, $amount, $username, $offer_code) {
//     $mysqli = connect();
//     if (!$mysqli) {
//         return "Failed to connect to the database.";
//     }
    
//     // $args = array_map(function($value) {
//     //     return trim($value);
//     // }, $args);

//     // foreach ($args as $value) {
//     //     if (empty($value)) {
//     //         echo 'error: ' . $mysqli->error;
//     //     }
//     // }

//     // foreach ($args as $value) {
//     //     if (preg_match("/([<|>])/", $value)) {
//     //         return "<> characters are not allowed";
//     //     }
//     // }

//     $stmt = $mysqli->prepare("INSERT INTO offers(offer_cover, type, name, end_date, amount, username, offer_code) VALUES(?,?,?,?,?,?,?)");
//     if (!$stmt) {
//         $error = $mysqli->error;
//         $mysqli->close();
//         return "Failed to prepare the SQL statement: " . $error;
//     }

//     $stmt->bind_param("bsssiis", $offer_cover, $type, $name, $end_date, $amount, $username, $offer_code);
//     $result = $stmt->execute();

//     if (!$result) {
//         $error = $mysqli->error;
//         $stmt->close();
//         $mysqli->close();
//         return "An error occurred while inserting the offer: " . $error;
//     }

//     $stmt->close();
//     $mysqli->close();

//     // Offer added successfully
//     $_SESSION["add"] = "Offer added successfully";
//     header("location: ../partner_company/company-feed.php");
//     exit();
// }
// function addoffer($offer_cover, $type, $name, $end_date, $amount, $username, $offer_code) {
//   $mysqli = connect();
//   $args = func_get_args();

//   $args = array_map(function($value) {
//       return trim($value);
//   }, $args);

//   foreach ($args as $value) {
//       if (empty($value)) {
//           echo 'error: ' . $mysqli->error;
//       }
//   }

//   foreach ($args as $value) {
//       if (preg_match("/([<|>])/", $value)) {
//           return "<> characters are not allowed";
//       }
//   }

//   $stmt = $mysqli->prepare("INSERT INTO offers(offer_cover, type, name, end_date, amount, username, offer_code) VALUES(?,?,?,?,?,?,?)");
//   if (!$stmt) {
//     echo $mysqli->error;
//   }
//   $stmt->bind_param("ssssiss", $offer_cover, $type, $name, $end_date, $amount, $username, $offer_code);
//   $stmt->execute();

//   if ($stmt === false) {
//     echo 'Error message: ' . $mysqli->error;
//     return "An error occurred. Please try again";
//     header("location: add-offer.php");
// } else if ($stmt->affected_rows != 1) {
//     return "An error occurred. Please try again";
//     header("location: add-offer.php");
// } else {
//     $_SESSION["add"] = "Offer added successfully";
//     header("location: ../partner_company/company-feed.php");
//     exit();
// }
// }


?>




