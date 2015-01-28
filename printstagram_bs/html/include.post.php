<?php
#################### HTML #####################
$post1_html = 
'    <div class="container theme-showcase" role="main">
        <div class="jumbotron">
          <h2> Photo submitted </h2>
        </div>
      </div>';

$post2_html = 
'      <div class="container theme-showcase" role="main">
        <div class="jumbotron">
          <h2> Post a Photo </h2>
          <form enctype="multipart/form-data" action="post.php" method="POST">
            Caption:<br>
            <input type="text" name="caption"><br>
            <input type="radio" name="is_pub" value="1" checked>Public<br>
            <input type="radio" name="is_pub" value="0">Private<br>
            <input name="MAX_FILE_SIZE" value="102400" type="hidden">
            <input name="image" accept="image/jpeg" type="file"><br>
            <input type="submit" value="Post">
          </form>
        </div>
      </div>';
###############################################

?>


