<?php require_once('Connections/cnx.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
  // For security, start by assuming the visitor is NOT authorized.
  $isValid = False;

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
  // Therefore, we know that a user is NOT logged in if that Session variable is blank.
  if (!empty($UserName)) {
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
    // Parse the strings into arrays.
    $arrUsers = Explode(",", $strUsers);
    $arrGroups = Explode(",", $strGroups);
    if (in_array($UserName, $arrUsers)) {
      $isValid = true;
    }
    // Or, you may restrict access to only certain users based on their username.
    if (in_array($UserGroup, $arrGroups)) {
      $isValid = true;
    }
    if (($strUsers == "") && true) {
      $isValid = true;
    }
  }
  return $isValid;
}

$MM_restrictGoTo = "index.php?msg= Veuillez vous connecter svp";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
    $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo);
  exit;
}
?>
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

$maxRows_DetailRS1 = 5;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_cnx, $cnx);
$query_DetailRS1 = sprintf("SELECT * FROM etudiants WHERE id = %s ORDER BY nom ASC", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $cnx) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?>
  <!DOCTYPE html>
  <html lang="en">
<head>
  <title>Details Etudiant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!--<link rel="stylesheet" href="style.css">-->

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!--<script src="style.js"></script>-->
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top " >
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topFixedNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      <a class="navbar-brand" href="index.php" style="color:#FFF">Accueil</a></div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="topFixedNavbar1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Admin<span class="sr-only">(current)</span></a></li>
        <li><a href="ajouter.php" style="color:#FFF">Gerer Utilisateur</a></li>

      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Session<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $logoutAction ?>">Se deconnecter</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>

<div class="container">
  <!--      <div class="row">-->
  <!--      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">-->
  <!--           <A href="edit.html" >Edit Profile</A>-->
  <!---->
  <!--       <br>-->
  <!--<p class=" text-info">May 05,2014,03:00 pm </p>-->
  <!--      </div>-->
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >


    <div class="panel panel-info" style="margin-top: 12%">
      <div class="panel-heading">
        <h3 class="panel-title"> <?php echo $row_DetailRS1['nom']; ?>  <?php echo $row_DetailRS1['prenoms']; ?></h3>
      </div>
      <div class="panel-body">
        <div class="row">

          <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
            <dl>
              <dt>DEPARTMENT:</dt>
              <dd>Administrator</dd>
              <dt>HIRE DATE</dt>
              <dd>11/12/2013</dd>
              <dt>DATE OF BIRTH</dt>
                 <dd>11/12/2013</dd>
              <dt>GENDER</dt>
              <dd>Male</dd>
            </dl>
          </div>-->
          <div class=" col-md-9 col-lg-9 ">
            <table class="table table-user-information">
              <tbody>
              <tr>
                <td>ID:</td>
                <td><?php echo $row_DetailRS1['id']; ?></td>
              </tr>
              <tr>
                <td>Prenom:</td>
                <td><?php echo $row_DetailRS1['prenoms']; ?></td>
              </tr>
              <tr>
                <td>Nom</td>
                <td><?php echo $row_DetailRS1['nom']; ?></td>
              </tr>

              <tr>
              <tr>
                <td>Login</td>
                <td><?php echo $row_DetailRS1['login']; ?></td>
              </tr>
              <tr>
                <td>Mot de passe </td>
                <td><?php echo $row_DetailRS1['mdp']; ?></td>
              </tr>
              <tr>
                <td>Adresse</td>
                <td><?php echo $row_DetailRS1['adresse']; ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><a href="mailto:info@support.com"><?php echo $row_DetailRS1['adresse']; ?></a></td>
              </tr>
              <tr>
                <td>Telephone</td>
                <td><?php echo $row_DetailRS1['telephone']; ?></td>

              </tr>

              </tbody>
            </table>

          </div>
        </div>
      </div>
      <div class="panel-footer">
        <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                    <span class="pull-right">
                        <a href="modifier.php?recordID=<?php echo $row_DetailRS1['id']; ?>" data-original-title="modifier cet Etudiant" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                        <a onclick="return confirm('Etes vous sur de le supprimer');" href="supprimer.php?recordID=<?php echo $row_DetailRS1['id']; ?>" data-original-title="Supprimer cet etudiant" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                    </span>
      </div>

    </div>
  </div>
</div>

<footer>
  <div class="footer-bottom" >

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
</body>
  </html><?php
mysql_free_result($DetailRS1);
?>