<?php

#Print header
$header = file_get_contents('html/header.html');
echo $header;

$_SESSION["username"];

# Timestamp
$time = time();

include ("include.php");
include ("html/include.post.php");

##################### SQL #####################
$pidSql = "SELECT MAX(pid) FROM photo";
$submitSql = "INSERT INTO photo (pid, poster, caption, pdate, lnge, lat, lname, is_pub) VALUES (?, ?, ?, FROM_UNIXTIME(?), 0, 0, \"location\", ?)";
$grantSQL = "GRANT FILE ON *.* TO 'root'@'localhost'";
$linkSQL = "UPDATE photo SET image = \"YES\" WHERE pid = ?";
$noImageSQL = "UPDATE photo SET image = \"NO\" WHERE pid = ?";
###############################################



if(!isset($_SESSION["username"])) {
  header("refresh: 1; index.php");
}

# User submitting photo
if(isset($_POST["is_pub"])) {
  # Get the pid for a new photo
  if ($stmt = $mysqli->prepare($pidSql)) {
      $stmt->execute();
      $stmt->bind_result($pid);
      $stmt->fetch();
      $pid++;
      $stmt->close();
  }

  # Add entry to photo table
  if ($stmt = $mysqli->prepare($submitSql)) {
    $stmt->bind_param("issii", $pid, $_SESSION["username"],
                        $_POST["caption"],  $time, $_POST["is_pub"]);
    $stmt->execute();
    $stmt->close();
  }

  # User provided a file path
  if (isset($_FILES['image'])) {
    try {   
      # Grant permission to move files
      if ($stmt = $mysqli->prepare($grantSQL)) {
        $stmt->execute();
        $stmt->close();
      } 
      # Permanent location of image
      $filepath = "/printstagram_bs/images/".$pid.".jpg";
      # Move file to permanent location
      move_uploaded_file($_FILES['image']['tmp_name'], "/var/www/html".$filepath);
      if ($stmt = $mysqli->prepare($linkSQL)) {
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $stmt->close();
      } 
      
    } catch (Exception $e) {
      echo '<h4>'.$e->getMessage().'</h4>';
    }

  } else {
    if ($stmt = $mysqli->prepare($noImageSQL)) {
      $stmt->bind_param("i", $pid);
      $stmt->execute();
      $stmt->close();
    } 
  }
  echo $post1_html;
  header("refresh: 1; view.php?pid=$pid");
} else {
  echo $post2_html;
}
# Print footer
$footer = file_get_contents('html/footer.html');
echo $footer;
?>





