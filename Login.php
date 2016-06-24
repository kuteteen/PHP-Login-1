<?php
  // connect to your database
  $db_handle = mysql_connect("Bloody", "MBFh", "P@csoft") or die(mysql_error());
  
  $link = mysql_select_db("Test") or die(mysql_error());
  
  // check if there is a login cookie
  if (isset($_COOKIE['UID']))
  {
      $username = addslashes($_COOKIE['UID']);
      $pass = addslashes($_COOKIE['PWD']);
      
      $dataset = mysql_query("SELECT * FROM users"
                           . " WHERE username='$username'") 
              or die(mysql_error());
      while ($row = mysql_fetch_array($dataset, MYSQL_ASSOC))
      {
          if (md5($pass) != $row['password'])
          {              
          }
          else
          {
              header("Location: member.php");
          }
      }
  }
  
  // if the login form is submitted
  if (isset($_POST['submit']))
  {
      // make sure they filled it in
      if(!$_POST['username'] | !$_POST['pass'])
      {
          die("You did not fill in a required field!");
      }
      
     // check it against the database
      if (!get_magic_quotes_gpc())
      {
        $_POST['username'] = addslashes($_POST['username']);
        $_POST['pass'] = addslashes($_POST['pass']);
      }
     
     $dataset = mysql_query("SELECT * FROM users WHERE username='".$_POST['username']."'")
             or die(mysql_error());
     
     // gives error if user doesn't exists
     $rowcount = mysql_num_rows($dataset);
     
     if ($rowcount == 0)
     {
         die('That user does not exists in our database. <a href=registration.php>Click Here to Register!</a>');
     }
     
     while($info = mysql_fetch_array($dataset, MYSQL_ASSOC))
     {
         // gives error if the password is wrong
         if (md5($_POST['pass']) != $info['password'])
         {
             die('Incorrect password, please try again!');
         }
         else
         {
              // if login is ok then we add a cookie
              $hour = time() + 3600;
              setcookie('UID', stripslashes($_POST['username']), $hour, '', $_SERVER['SERVER_NAME']);
              setcookie('PWD', stripslashes($_POST['pass']), $hour, '', $_SERVER['SERVER_NAME']);

              // then redirect them to the members area
              header("Location: member.php");
          }
     }
  }
  else
  {      // if they are not logged in
?>
    <link rel="stylesheet" type="text/css" href="../UI/wlee.css">
    <form action="<?php print $_SERVER['PHP_SELF']?>" method="POST">
        <table border="0">
            <tr><td colspan="2"><h1>Login</h1></td></tr>
            <tr><td>User Name:</td>
                <td><input type="text" name="username" maxlength="40"></td></tr>
            <tr><td>Password:</td>
                <td><input type="text" name="pass" maxlength="50"></td></tr>
            <tr><td colspan="2" align="right">
                    <input type="submit" name="submit" value="Login"> 
                </td></tr>
        </table>
    </form>
<?php
  }
?>  
  
  