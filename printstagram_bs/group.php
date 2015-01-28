<?php
#TODO
#Print header
$header = file_get_contents('html/header.html');
echo $header;

##################### SQL #####################
$group_sql = 
"SELECT gname
FROM friendGroup
WHERE ownername = ?";

$member_sql = 
"SELECT username
FROM inGroup
WHERE gname = ? AND ownername = ?";

$remove_sql = 
"DELETE FROM inGroup
WHERE ownername = ? AND gname = ? AND username = ?";

$add_sql = 
"INSERT INTO inGroup (ownername, gname, username)
VALUES (?, ?, ?)";

$addGroup_sql =
"INSERT INTO friendGroup (gname, descr, ownername)
VALUES (?, ?, ?)";

$search_sql = 
"SELECT username
FROM person
WHERE fname = ? AND lname = ?";
###############################################

include ("include.php");
include ("html/include.group.php");

# If not logged in, go to start page
if(!isset($_SESSION["username"])) {
  header("refresh: 1; index.php");
}

# Get info from request
$username = $_SESSION["username"];

# Remove friend from group if given
if(isset($_POST["remove"])) {
  if ($stmt = $mysqli->prepare($remove_sql)) {
    $stmt->bind_param("sss", $username, $_POST["group"], $_POST["member"]);
    $stmt->execute();
    $stmt->close();
  }
}

# Add friend to group
if(isset($_POST["add"])) {
  if ($stmt = $mysqli->prepare($add_sql)) {
    $stmt->bind_param("sss", $username, $_POST["group"], $_POST["username"]);
    $stmt->execute();
    $stmt->close();
  }
}

# Add group
if(isset($_POST["addGroup"])) {
  if ($stmt = $mysqli->prepare($addGroup_sql)) {
    $stmt->bind_param("sss", $_POST["group"], $_POST["descr"], 
                      $_SESSION["username"]);
    $stmt->execute();
    $stmt->close();
  }
}

# Search for person if name given
if(isset($_POST["search"])) {
  if ($stmt = $mysqli->prepare($search_sql)) {
    $fname = htmlspecialchars($_POST["fname"]);
    $lname = htmlspecialchars($_POST["lname"]);
    $stmt->bind_param("ss", $_POST["fname"], $_POST["lname"]);
    $stmt->execute();
    $stmt->bind_result($username);
    
    if ($stmt->fetch()) {
      echo $group1_html.$group2_html."Results for $fname $lname\n</div>";
      $username = htmlspecialchars($username);
      echo $group13_html.$username.$group14_html.$username.$group15_html.
           $_POST["group"].$group16_html;
    } else {
      echo "No results found";
    }
    while ($stmt->fetch()) {
      
      
      
    }
    echo "</div></div>";
    $stmt->close();
  }
} else {
  # Get groups
  if ($stmt = $mysqli->prepare($group_sql)) {
    $groups = array();
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($group);

    while ($stmt->fetch()) {
      $group = htmlspecialchars($group);
      array_push($groups, $group);
    }

    $stmt->close();
  }

  echo $group1_html;
  while (!empty($groups)) {
    $group = array_shift($groups);
    if ($stmt = $mysqli->prepare($member_sql)) {    
      $stmt->bind_param("ss", $group, $username);
      $stmt->execute();
      $stmt->bind_result($member);
      echo $group2_html.$group.$group4_html;
      while ($stmt->fetch()) {
        $member = htmlspecialchars($member);
        echo $group6_html.$member.$group7_html.$group.$group8_html.$member.$group9_html;
      }
      echo $group10_html.$group.$group12_html;
      $stmt->close();
    }
  }
  echo $group17_html;
          
}
echo $group11_html;
# Print footer
$footer = file_get_contents('html/footer.html');
echo $footer;

?>
