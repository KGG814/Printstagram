<?php
#################### HTML #####################
$imagehead_html = '          <div class="col-md-6">'."\n".
"            <a href=\"view.php?pid=";

$imagetail_html =
'</a>
'."          </div>\n";

$welcome_html1 = 
'    <div class="container theme-showcase" role="main">
      <div class="jumbotron">
        <h1>Welcome ';

$welcome_html2 = '</h1>
        <p><a href="post.php" class="btn btn-primary btn-lg"'.
        ' role="button">Post a Photo</a>
        <a href="yourPhotos.php" class="btn btn-primary btn-lg"'.
        ' role="button">View Your Photos</a>
        <p><a href="group.php" class="btn btn-primary btn-lg"'.
        ' role="button">Manage groups</a>
        <a href="tags.php" class="btn btn-primary btn-lg"'. 
        ' role="button">Manage Tags</a></p>'.
        "\n      </div>\n".
        "      <div class=\"jumbotron\"><h3>Your Friends' Photos</h3> </br>\n".
        "        <div class=\"container\">\n";

$footer_html = 
"        </div>
      </div>\n\n";


$login_html =
'     <div class="container theme-showcase" role="main">
        <div class="jumbotron">
          <h1>Welcome to Printstagram</h1>
          <p><a href="/printstagram_bs/login.php" class="btn btn-primary btn-lg" 
          role="button">Log In &raquo;</a></p>
        </div>
      </div> <!-- /container -->';
###############################################

?>


