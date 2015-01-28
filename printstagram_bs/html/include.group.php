<?php
  $group1_html = '    <div class="col-md-2"></div>
    <div class="col-md-8">'."\n";

  $group2_html = '      <div class="panel panel-default">
        <div class="panel-heading">';
  
  $group3_html = '          </tbody>
        </table>
      </div>'."\n";

  $group4_html = '</div>     
        <table class="table">
          <thead>
            <tr>
              <th> Members </th>
              <th> Action </th>
            </tr>
          </thead>
          <tbody>'."\n";

  $group5_html = '    </div>
    <div class="col-md-2"></div>'."\n";

  $group6_html = '            <tr>
              <td>';

  $group7_html = '</td>
              <td> 
                <form action="group.php" method="POST">
                <button name="remove" type="submit" value="TRUE">Remove</button>
                <input type="hidden" name="group" value=';

  $group8_html = '>
                <input type="hidden" name="member" value=';

  $group9_html = '>
                </form>
              </td>
            </tr>'."\n";

  $group10_html = '          </tbody>
        </table>
        <form action="group.php" method="POST">
          First Name <input type="text" name="fname">
          Last Name <input type="text" name="lname">
          <button name="search" type="submit" value="TRUE">Add</button>
          <input type="hidden" name="group" value="';
  $group12_html = '">
        </form>
      </div>'."\n";

  $group11_html = '    </div>
    <div class="col-md-2"></div>'."\n";

  $group13_html = '    <table class="table">
      <thead>
        <tr>
          <th> Username </th>
          <th>  Action </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td> ';
  $group14_html = '</td>
          <td>
            <form action="group.php" method ="POST">
              <input type="hidden" name="username" value="';

  $group15_html = '">
              <input type="hidden" name="group" value="';
  
  $group16_html = '">
              <button name="add" type="submit" value="TRUE">Add</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>';

  $group17_html = '<form action="group.php" method="POST">
          Group Name <input type="text" name="group">
          Description <input type="text" name="descr">
          <button name="addGroup" type="submit" value="TRUE">Add</button>
        </form>';
?>
