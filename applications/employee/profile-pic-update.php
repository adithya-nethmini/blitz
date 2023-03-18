<?php

include '../function/function.php';
$mysqli = connect();

if(isset($_FILES["profilepic_e"]["name"])){
    $user = $_SESSION['user'];

    $imageName = $_FILES["profilepic_e"]["name"];
    $imageSize = $_FILES["profilepic_e"]["size"];
    $tmpName = $_FILES["profilepic_e"]["tmp_name"];

    // Image validation
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)){
      echo
      "
      <script>
        alert('Invalid Image Extension');
        document.location.href = 'profile';
      </script>
      ";
    }
    elseif ($imageSize > 1200000){
      echo
      "
      <script>
        alert('Image Size Is Too Large');
        document.location.href = profile';
      </script>
      ";
    }
    else{
      $newImageName = $user . " - " . date("Y.m.d") . " - " . date("h.i.sa"); // Generate new image name
      $newImageName .= '.' . $imageExtension;
      $query = "UPDATE tb_user SET image = '$newImageName' WHERE username = $user";
      mysqli_query($mysqli, $query);
      move_uploaded_file($tmpName, '../../views/images/' . $newImageName);
      echo
      "
      <script>
      document.location.href = profile';
      </script>
      ";
    }
  }
?>
