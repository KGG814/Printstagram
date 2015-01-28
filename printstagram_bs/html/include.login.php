<?php
#################### HTML #####################
$error_html =
'<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <div class="alert alert-danger" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
      Your username or password is incorrect, click 
      <a href="login.php">here</a> to try again.
    </div>
  </div>
  <div class="col-md-4"></div>
</div>';
$login_html = 
'<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <div class="jumbotron">
      <div class="login-panel">
        <form action="login.php" method="POST" role="form">
          <div class="form-group">
            <input type="text" class="form-control" name="username" 
            placeholder="Username">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" 
            placeholder="Password">
          </div>
          <button type="submit" class="btn btn-default">Login</button>
          <div class="hidden">
            <input type="submit" value="Submit">
          </div>
        </form>
      </div>
    </div>
  </div>
  <bdiv class="col-md-4"></div>
</div>';
###############################################
?>

