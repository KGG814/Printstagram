<?php

#Print header
$header = file_get_contents('html/header.html');
echo $header;

# Timestamp
$time = time();

##################### SQL #####################
$comment_sql = 
"SELECT username, ctext, ctime
FROM comment NATURAL JOIN commentOn
WHERE pid = ?
ORDER BY ctime ASC";
$tag_sql = 
"SELECT tagger, ttime, taggee
FROM tag
WHERE pid = ? AND tstatus = 1";
$check_sql = 
"SELECT *
FROM ((SELECT pid
FROM photo NATURAL JOIN shared NATURAL JOIN inGroup
WHERE username = ?)
UNION
(SELECT pid
FROM photo
WHERE poster = ? OR is_pub = 1)) as T
WHERE pid = ?";
$photo_sql = 
"SELECT poster, image, is_pub, caption
FROM photo
WHERE pid = ?";
$group_sql = 
"SELECT gname
FROM friendGroup
WHERE ownername = ?";
$addgroup_sql = 
"INSERT INTO shared (pid, gname, ownername)
VALUES (?, ?, ?)";
$users_sql = 
"SELECT username
FROM person";
$addtag_sql = 
"INSERT INTO tag (pid, tagger, taggee, ttime, tstatus)
VALUES (?, ?, ?, FROM_UNIXTIME(?), ?)";
###############################################

include ("include.php");
include ("html/include.view.php");

# If not logged in, go to start page
if(!isset($_SESSION["username"])) {
  header("refresh: 1; index.php");
}

# Get info from request
$pid = htmlspecialchars($_GET["pid"]);
$username = htmlspecialchars($_SESSION["username"]);


if(isset($pid)) {
  # Check the user has permission to view photo
  if ($stmt = $mysqli->prepare($check_sql)) {
    $stmt->bind_param("ssi", $username, $username, $pid);
    $stmt->execute();
    if (!$stmt->fetch()) {
      echo $error_html;
      exit();
    }
    $stmt->close();
  }

  ####### Setting variables in database from user input #######
  # Add photo to group if requested
  if(isset($_POST["group"])) {
    $group = $_POST["group"];
    if ($stmt = $mysqli->prepare($addgroup_sql)) {
      $stmt->bind_param("iss", $pid, $group, $username);
      $stmt->execute();
      $stmt->close();
    }
  }

  # Add tag if requested
  if(isset($_POST["tag"])) {
    $tag = $_POST["tag"];
    if (strcmp($username, $tag) == 0) {
      $tstatus = 1;
    } else {
      $tstatus = 0;
    }
    if ($stmt = $mysqli->prepare($addtag_sql)) {
      $stmt->bind_param("issii", $pid, $username, $tag, $time, $tstatus);
      $stmt->execute();
      $stmt->close();
    }
  }
#############################################################
 
  echo $view1_html;

  # Print photo or placeholder and name of poster
  if ($stmt = $mysqli->prepare($photo_sql)) {
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->bind_result($poster, $hasPhoto, $is_pub, $caption);
    $poster = htmlspecialchars($poster);
    $hasPhoto = htmlspecialchars($hasPhoto);
    $caption = htmlspecialchars($caption);
    if ($stmt->fetch()) {
      # No image found     
      if (empty($hasPhoto)) {
        $filepath = "/printstagram_bs/images/imageNotFound.jpg";
      # Image found
      } else {
        $filepath = "/printstagram_bs/images/".$pid.".jpg";      
      }
      echo $view14_html.$filepath.$view15_html;
      echo "          ".$poster." <br>\n";
    }
    $stmt->close();
  }
  
  # Print tags in chronological order
  echo $view9_html;
  if ($stmt = $mysqli->prepare($tag_sql)) {  
    $stmt->bind_param("i", $pid);    
    $stmt->execute();   
    $stmt->bind_result($tagger, $ttime, $taggee); 
    $tagger = htmlspecialchars($tagger);
    $taggee = htmlspecialchars($taggee); 
    if($stmt->fetch()) {  
      echo "          ".$caption." - with \n";    
      echo $view16_html.$tagger." at ".$ttime."\">$taggee</a>";
    } 
    while($stmt->fetch()) {      
      echo ", ".$view16_html.$tagger." at ".$ttime."\">$taggee</a>";
    }
    echo "<br><br>\n";
    $stmt->close();
  } 

  # Print comments in chronological order
  if ($stmt = $mysqli->prepare($comment_sql)) {  
    $stmt->bind_param("i", $pid);    
    $stmt->execute();   
    $stmt->bind_result($username, $ctext, $ctime);
    $username = htmlspecialchars($username);
    $ctext = htmlspecialchars($ctext);    
    while($stmt->fetch()) {      
      echo "          <strong>$username</strong> $ctext<br>";
      echo " <small>$ctime</small> <br>";
    }
    echo $view3_html;
    $stmt->close();
  }  

  # Tagging
  if ($stmt = $mysqli->prepare($users_sql)) {
    $stmt->execute();
    $stmt->bind_result($user);
    $user = htmlspecialchars($user);
    echo $view5_html.$pid.$view11_html;
    while ($stmt->fetch()) {
      echo "  ".$view12_html.$user.">".$user."</option>\n";
    }
    echo $view4_html;
    $stmt->close();
  }

  # Add option to share with friends if photo is current user's and private
  if (strcmp ($username, $poster) == 0 && $is_pub == 0) {
    if ($stmt = $mysqli->prepare($group_sql)) {
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $stmt->bind_result($group);
      if ($stmt->fetch()) {
        $group = htmlspecialchars($group);
        echo "<br>".$view5_html.$pid.$view6_html;
        echo $view12_html.$group.">".$group."</option>\n";
        while ($stmt->fetch()) {
          $group = htmlspecialchars($group);
          echo $view12_html.$group.">".$group."</option>\n";
        }
        echo $view7_html;
      } else {
        echo $view13_html;
      }
     
      $stmt->close();
    }
  }

  echo $view2_html;

} else {
  echo "Error, pid not set";
}

# Print footer
$footer = file_get_contents('html/footer.html');
echo $footer;
?>
