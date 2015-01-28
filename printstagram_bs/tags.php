<?php
#Print header
$header = file_get_contents('html/header.html');
echo $header;

##################### SQL #####################
$tag_sql = 
"SELECT tagger, ttime, pid
FROM tag
WHERE taggee = ? AND tstatus = 0";

$accept_sql = 
"UPDATE tag
SET tstatus = 1
WHERE pid = ? AND taggee = ? AND tagger = ?";

$reject_sql = 
"DELETE FROM tag
WHERE pid = ? AND taggee = ? AND tagger = ?";
###############################################

include ("include.php");
include ("html/include.tags.php");

# If not logged in, go to start page
if(!isset($_SESSION["username"])) {
  header("refresh: 1; index.php");
}

# Get info from request
$username = htmlspecialchars($_SESSION["username"]);

# Evaluate tag status if given
if(isset($_POST["tagState"])) {
  $tagState = $_POST["tagState"];
  $pid = $_POST["pid"];
  $taggee = $_POST["taggee"];
  $tagger = $_POST["tagger"];
  # Change tag status to accepted
  if (strcmp($tagState, "accept") == 0) {
    if ($stmt = $mysqli->prepare($accept_sql)) {
      $stmt->bind_param("sss", $pid, $taggee, $tagger);
      $stmt->execute();
      $stmt->close();
    }
  # Delete tag
  } elseif (strcmp($tagState, "reject") == 0){
    if ($stmt = $mysqli->prepare($reject_sql)) {
      $stmt->bind_param("sss", $pid, $taggee, $tagger);
      $stmt->execute();
      $stmt->close();
    }
  }
}

#############################################################
# Tags
if ($stmt = $mysqli->prepare($tag_sql)) {
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->bind_result($tagger, $ttime, $pid);
  $tagger = htmlspecialchars($tagger);
  $ttime = htmlspecialchars($ttime);
  $pid = htmlspecialchars($pid);
  
  echo $tags1_html;

  while ($stmt->fetch()) {
    echo "            <tr>
            <td> $tagger </td>
            <td> $ttime  </td>\n".
    $tags2_html.$pid.$tags3_html.$pid.$tags4_html.
    $tags8_html.$pid.$tags7_html.$username.
     $tags9_html.$tagger.$tags6_html;
  }
  $stmt->close();
  echo $tags5_html;
}

# Print footer
$footer = file_get_contents('html/footer.html');
echo $footer;

?>
