<?php

# Print header
$header = file_get_contents('html/header.html');
echo $header;

##################### SQL #####################
$photo_sql = "(SELECT pid, poster, pdate, caption, image
FROM photo NATURAL JOIN shared NATURAL JOIN inGroup
WHERE username = ? AND poster != ?)
UNION
(SELECT pid, poster, pdate, caption, image
FROM photo
WHERE is_pub = 1 AND poster != ?)
ORDER BY pdate DESC";
###############################################

include ("include.php");
include ("html/include.index.php");

if(!isset($_SESSION["username"])) {
  # Not logged in
  echo $login_html;
} else {
  # Logged In
  $username = htmlspecialchars($_SESSION["username"]);
  echo $welcome_html1.$username.$welcome_html2;
  # Post all public, shared and own photos
  if ($stmt = $mysqli->prepare($photo_sql)) {
    $stmt->bind_param("sss", $username, $username, $username);
    $stmt->execute();
    $stmt->bind_result($pid, $poster, $pdate, $caption, $image);
    $poster = htmlspecialchars($poster);
    $pdate = htmlspecialchars($pdate);
    $caption = htmlspecialchars($caption);
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


