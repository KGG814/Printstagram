<?php

# Print header
$header = file_get_contents('html/header.html');
echo $header;

##################### SQL #####################
$myphoto_sql = "(SELECT pid, image
FROM photo
WHERE poster = ?)
ORDER BY pdate DESC";
###############################################

include ("include.php");
include ("html/include.yourPhotos.php");

if(!isset($_SESSION["username"])) {
  # Not logged in
  echo $login_html;
} else {
  # Logged In
  $username = htmlspecialchars($_SESSION["username"]);
  echo $welcome_html1.$username.$welcome_html2;
  # Post all public, shared and own photos
  if ($stmt = $mysqli->prepare($myphoto_sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($pid, $image);
    while ($stmt->fetch()) {
      echo $imagehead_html;
      echo "$pid\" class=\"thumbnail\">\n";
      if (strcmp($image, "YES") == 0) {
        echo "            <img src=\"images/$pid.jpg\">";
      } else {
        echo "            <img src=\"images/imageNotFound.jpg\">";
      }
      echo $imagetail_html;
    }
    $stmt->close();
    $mysqli->close();
  }
}

# Print footer
echo $footer_html;
$footer = file_get_contents('html/footer.html');
echo $footer;
?>


