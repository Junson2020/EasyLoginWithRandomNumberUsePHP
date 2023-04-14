<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include_once('globalJunson.inc.php');
include_once($JUNSON_COMMON_INC);

session_start();
if(isset($_SESSION['junsonlicense'])) { 
	$junsonlicense=$_SESSION['junsonlicense']; 
} else { $junsonlicense=""; }

$data = GetInput();
if(isset($data['uAccount'])) { $username = $data['uAccount']; } else { $username=""; }
if(isset($data['upswd'])) { $password = $data['upswd']; } else { $password=""; }
?>
<HTML>
<HEAD>
<title>Login</title>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
<script src='//code.jquery.com/jquery-2.1.3.min.js'></script>
<script> 
$(document).ready ( function() {
  $('#loginB').click(function() {
    $.ajax (
            {
              url:'chklogin.php',
              data:
              {
                uAccount: $('#uAccount').val(),
                upswd:$('#upswd').val(),
                randpswd: $('#randpswd').val()
              },
              error: function(xhr)
              {
                alert('Ajax request Fail~');
                location.href='login.php';
              },
              success:function(response)
              { 
                if(response=='Error')
                { alert('Password not Match~');
                  location.href='login.php?uAccount='+$('#uAccount').val();
                }else if(response=='Randnumber')
                { alert('Verification Code not Match');
                  location.href='login.php?uAccount='+$('#uAccount').val()+'&upswd='+$('#upswd').val();
                }else if(response=='OK')
                { alert('LOGIN OK');
                  location.href='index.php';
                }else {
                	alert('Others'+response);
                  location.href='login.php?uAccount='+$('#uAccount').val()+'&upswd='+$('#upswd').val();
                }
              }
    });
  });
});
</script>

<body>
<form>
	<table border="1">
  	<legend>Login Information</legend>
<?php
  echo '<tr>';
  echo ' <td>Account</td>';
  echo ' <td><input type="text" id="uAccount" value="'.$username.'"></td>';
  echo '</tr>';

  echo '<tr>';
  echo ' <td>Password</td>';
  echo ' <td><input type="password" id="upswd" value="'.$password.'" /></td>';
  echo '</td>';

  echo '<tr>';
  echo ' <td>CAPTCHA</td>';
  echo ' <td><font size="3" color="red"><b><img src="randimg.php"></img></b></font>';
  echo '	   <input type="text" id="randpswd" /></td>';
  echo '</tr>';
  
  echo '<tr>';
  echo ' <td colspan=2>';
  echo '  <input type="button" name="loginB" id="loginB" value="Login">';
  echo ' </td>';
  echo '</tr>';
?>
  </table>
</form>
</body>
</HTML>