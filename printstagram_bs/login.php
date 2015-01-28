<?php

# Print header
$header = file_get_contents('html/header.html');
echo $header;

##################### SQL #####################
$login_sql = 
"SELECT username, password 
FROM person 
WHERE username = ? and password = ?";
###############################################

include ("include.php");
include("html/include.login.php");

if(isset($_SESSION["username"])) {
  # Logged In
  $username = htmlspecialchars($_SESSION["username"]);
  echo '<div class="container theme-showcase" role="main">
        <div class="jumbotron">
          <h1>Welcome '.$username.'</h1>
          <p> You are already logged in </p>
        </div>
      </div> <!-- /container -->';
} else {
  # Logging in
  if(isset($_POST["username"]) && isset($_POST["password"])) {
    # Check if entry exists in database
    if ($stmt = $mysqli->prepare($login_sql)) {
      
      $stmt->bind_param("ss", $_POST["username"], md5($_POST["password"]));
      $stmt->execute();
      $stmt->bind_result($username, $password);
      $username = htmlspecialchars($username);
      $password = htmlspecialchars($password);
	    # If there is a match set session variables and send user to homepage
      
      if ($stmt->fetch()) {
		    $_SESSION["username"] = $username;
		    $_SESSION["password"] = $password;
        # Store clients IP address to help prevent session hijack
		    $_SESSION["REMOTE_ADDR"] = $_SERVER["REMOTE_ADDR"]; 
        header("refresh: 0; index.php");
      # If no match then tell them to try again
      } else {        
		    sleep(1); //pause a bit to help prevent brute force attacks
		    echo $error_html;
	    }
      $stmt->close();
	    $mysqli->close();
    }
  # Not Logged In
  } else {
    echo $login_html;
    
  }
}

# Print footer
$footer = file_get_contents('html/footer.html');
echo $footer;
?>

