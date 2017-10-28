<?php require_once('Connections/cnx.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['login'])) {
  $loginUsername=$_POST['login'];
  $password=$_POST['mdp'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admin.php";
  $MM_redirectLoginFailed = "index.php?msg=login ou mdp incorrect";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_cnx, $cnx);
  
  $LoginRS__query=sprintf("SELECT login, mdp FROM etudiants WHERE login=%s AND mdp=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $cnx) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="public/css/messtyles.css">
  
<title>NTech</title>
</head>

<body style="padding-top: 120px">

<form name="form1" method="POST" action="<?php echo $loginFormAction; ?>">

 <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="public/image/icon.png" width="138" height="161" />
            <p id="profile-name" class="profile-name-card"></p>
            <div class="form-signin">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text"  name="login" id="login" class="form-control" placeholder="Login" required autofocus>
                <input type="password" name="mdp" id="mdp" class="form-control" placeholder="Mot de Passe" required>
               
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Se Connecter</button>
            </div><!-- /form -->
   </div><!-- /card-container -->
</div><!-- /container -->

</form>
&nbsp;
<p style="color:red">
<?php if (isset($_REQUEST["msg"]))
echo $_REQUEST["msg"]; ?>
</p>



 

</body>
<footer >
  <div class="footer-bottom">

    <div class="container">

      <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

          <div class="copyright">

            © 2017, NostressTeam, Tout droit reservé

          </div>

        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

          <div class="design">

            <a href="#">NoStressTeam</a> |  <a href="#">Web Design & Developpé par NoStressTeam</a>

          </div>

        </div>

      </div>

    </div>

  </div>

</footer>
</html>