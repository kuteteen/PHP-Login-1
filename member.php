<?php
  // connect to your database
  $db_handle = mysql_connect("Bloody", "MBFh", "P@csoft") or die(mysql_error());
  
  $link = mysql_select_db("Test") or die(mysql_error());
  
  // check cookies to make sure they are logged in
  if(isset($_COOKIE['UID']))
  {
      $username = addslashes($_COOKIE['UID']);
      $pass = addslashes($_COOKIE['PWD']);
      $dataset = mysql_query("SELECT * FROM users "
                           . " WHERE username='$username'")
              or die(mysql_error());
      while($info = mysql_fetch_array($dataset, MYSQL_ASSOC))
      {
          // if the cookies has the wrong password, they are taken to the login page
          if (md5($pass) != $info['password'])
          {
              header("Location: login.php");
          }
          
          //otherwise they are shown the adminstrator area
          else
          {
?>
    <html>
    <head>
        <title>:::::{<?php print $username."'s"?> Page}:::::</title>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../UI/wlee.css">
    </head>

    <body>
        <?php printf ("<br>Good day! %s<br>", stripslashes($username)); ?>

        <form action="contact.php" method="GET">  
            <table align=center>  
                <tr><td colspan=2><strong>Contact us using this form:</strong></td></tr>  
                <tr><td>Department:</td><td>
                        <select name="sendto"> 
                            <option value="wei_ming1977@yahoo.com">Yahoo General</option> 
                            <option value="wei.ming@mbfh.com.my">MBFh IT Support</option> 
                            <option value="weiming77@gmail.com">Google Sales</option> 
                        </select></td></tr>  
                <tr><td><font color=red>*</font> Name:</td><td><input size=25 name="Name"></td></tr>  
                <tr><td><font color=red>*</font> Email:</td><td><input size=25 name="Email"></td></tr>  
                <tr><td>Company:</td><td><input size=25 name="Company"></td></tr>  
                <tr><td>Phone:</td><td><input size=25 name="Phone"></td></tr>  
                <tr><td>Subscribe to<br> mailing list:</td>
                    <td><input type="radio" name="list" value="No"> No Thanks<br> 
                        <input type="radio" name="list" value="Yes" checked> Yes, keep me informed<br></td></tr>  
                <tr><td colspan=2>Message:</td></tr>  
                <tr><td colspan=2 align=center><textarea name="Message" rows=5 cols=35></textarea></td></tr>  
                <tr><td colspan=2 align=center><input type=submit name="send" value="Submit"></td></tr>  
                <tr><td colspan=2 align=center><small>A <font color=red>*</font> indicates a field is required</small></td></tr>  
            </table>  
        </form>  
    </body>  
    </html>
<?php
              print "<a href=logout.php>Click Logout</a>";
          }
      }      
  }
  
  //if the cookie does not exists, they are taken to the login page
  else
  {
      header("Location:: login.php");
  }
?>