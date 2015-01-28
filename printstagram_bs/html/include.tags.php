<?php
#################### HTML #####################
$tags1_html = '    <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">Pending tags</div>     
            <table class="table">
              <thead>
                <tr>
                  <th> Tagger </th>
                  <th> Time   </th>
                  <th> Photo  </th>
                  <th> Action </th>
                </tr>
              </thead>
            <tbody>'."\n";

$tags2_html = '            <td> <a href="view.php?pid=';

$tags3_html = "\" class=\"thumbnail\">
            <img src=\"images/";

$tags4_html = ".jpg\" style=\"width: 100px;\"></a></td>
            <td>\n";

$tags5_html = '          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-2"></div>'."\n";

$tags6_html = ">
              </form>
            </td>
            </tr>\n";

$tags7_html = '>
                <input type="hidden" name="taggee" value=';

$tags8_html = '              <form action="tags.php" method="POST">
                <button name="tagState" type="submit" value="accept">Accept</button>
                <button name="tagState" type="submit" value="reject">Reject</button>
                <input type="hidden" name="pid" value=';

$tags9_html = '>
                <input type="hidden" name="tagger" value=';

###############################################
?>

