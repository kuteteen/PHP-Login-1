        <?php
          $db_handle = mysql_connect("Bloody", "MBFh", "P@csoft") or die(mysql_error());

          mysql_select_db("Test", $db_handle) or die(mysql_error());


          // this code runs if the form has been summitted
          if (isset($_POST['submit']))
          {
            // This make sure they did not leave any fields blank
            if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'])
            {
              die('You did not complete all of the required fields!');
            }
          
            if (!get_magic_quotes_gpc())
            {
              $_POST['pass'] = addslashes($_POST['pass']);
              $_POST['pass2'] = addslashes($_POST['pass2']);
              $_POST['username'] = addslashes($_POST['username']);
            }  

            // checks if the username is in use           
            $usercheck = $_POST['username'];
            $result = mysql_query("SELECT username FROM users WHERE username='$usercheck'") 
                   or die(mysql_error());
            $recordcount = mysql_num_rows($result);
            mysql_free_result($result); 

            // if the name exists it gives an error
            if ($recordcount != 0)
            { 
              die('Sorry, the username '.$_POST['username'].' is already in use!');
            }

            // this make sure both passwords entered match
            if ($_POST['pass'] != $_POST['pass2'])
            {
              die('Your passwords did not match!');
            }

            // now we can insert it into the database
            $insert = "INSERT INTO users (username, password)
                       VALUES ('".$_POST['username']."', '".md5($_POST['pass'])."')";
            $add_member = mysql_query($insert);

            $row_affected = mysql_affected_rows($db_handle);

            mysql_close();
        ?>
            <h1><?php printf("%d ", $row_affected) ?>user(s) registered!</h1>
            <p>Thank you, you have registered - you may now <a href=login.php>login</a>.</p> 
        <?php

          } 
          // End of Posting form

          // This is Registration form
          else 
          {
        ?>
        
        <link rel="stylesheet" type="text/css" href="../UI/wlee.css">
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
          <table border="0">
            <tr>
              <td>User Name:</td>
              <td><input type="text" name="username" maxlength="60"></td>
            </tr>
            <tr>
              <td>Password:</td>
              <td><input type="text" name="pass" maxlength="10"></td>
            </tr>
            <tr>
              <td>Confirm Password:</td>
              <td><input type="text" name="pass2" maxlength="10"></td>
            </tr>
            <tr>
              <th colspan=2>
                <input type="submit" name="submit" value="registration">
              </th> 
            </tr>
          </table>
        </form> 

        <?php

          } 
          // End of Registration form
       ?>