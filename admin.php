<?php require_once('Connections/cnx.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
session_start();

}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
$logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
//to fully log out a visitor we need to clear the session varialbles
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
$_SESSION['PrevUrl'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
unset($_SESSION['PrevUrl']);

$logoutGoTo = "index.php?msg=Deconnexion reussi";
if ($logoutGoTo) {
header("Location: $logoutGoTo");
exit;
}
}
?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 5;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
$pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_cnx, $cnx);
$query_Recordset1 = "SELECT * FROM etudiants ORDER BY nom ASC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $cnx) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
$totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
$all_Recordset1 = mysql_query($query_Recordset1);
$totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
$params = explode("&", $_SERVER['QUERY_STRING']);
$newParams = array();
foreach ($params as $param) {
if (stristr($param, "pageNum_Recordset1") == false && 
stristr($param, "totalRows_Recordset1") == false) {
array_push($newParams, $param);
}
}
if (count($newParams) != 0) {
$queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
}
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Liste Etudiant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
  <div class="row">

    <div class="alert alert-warning">
      <?php if (isset($_REQUEST["msg"]))
          echo $_REQUEST["msg"]; ?>
    </div>
    <h1>Liste des etudiants de l'estm</h1>
    <div class="alert alert-info">Dashbord, il nous permet d'avoir une vue d'ensemble sur nos etudiants </div>



    <div class="col-md-10 col-md-offset-1">

      <div class="panel panel-default panel-table">
        <div class="panel-heading">
          <div class="row">
            <div class="col col-xs-6">
              <h3 class="panel-title">Liste Etudiants</h3>
            </div>
            <div class="col col-xs-6 text-right">
              <a type="button" href="ajouter.php" class="btn btn-sm btn-primary btn-create">Ajouter</a>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-list">
            <thead>
            <tr>
              <th><em class="fa fa-cog"></em></th>
              <th >ID</th>
              <th>Prenom</th>
              <th>Nom</th>
              <th>Telephone</th>
              <th class="hidden-xs">Adresse</th>
              <th>Adresse Electronique</th>
            </tr>
            </thead>
            <?php do { ?>
            <tbody>
            <tr>
              <td align="center">
                <a href="modifier.php?recordID=<?php echo $row_Recordset1['id']; ?>" class="btn btn-default"><em class="fa fa-pencil"></em></a>
                <a onclick="return confirm('Etes vous sur de le supprimer');" href="supprimer.php?recordID=<?php echo $row_Recordset1['id']; ?>"
                   class="btn btn-danger"><em class="fa fa-trash"></em></a>
              </td>
              <td ><a href="details.php?recordID=<?php echo $row_Recordset1['id']; ?>"> <?php echo $row_Recordset1['id']; ?>&nbsp; </a></td>
              <td><?php echo $row_Recordset1['prenoms']; ?>&nbsp; </td>
              <td><?php echo $row_Recordset1['nom']; ?>&nbsp; </td>
              <td><?php echo $row_Recordset1['telephone']; ?>&nbsp; </td>
              <td class="hidden-xs"><?php echo $row_Recordset1['adresse']; ?>&nbsp; </td>
              <td><?php echo $row_Recordset1['email']; ?>&nbsp; </td>
            </tr>
            </tbody>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
          </table>

        </div>
        <div class="panel-footer">
          <div class="row">
            <div class="col col-xs-4">
              Page <?php echo ($startRow_Recordset1 + 1) ?> à <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> sur <?php echo $totalRows_Recordset1 ?>

            </div>

            <div class="col col-xs-8">
              <ul class="pagination hidden-xs pull-right">
                <?php if ($pageNum_Recordset1 > 0)
                  {
                     // Show if not first page0
                    ?>
                    <li>
                      <a href="<?php printf('%s?pageNum_Recordset1=%d%s', $currentPage, 0, $queryString_Recordset1); ?>">Premier</a>
                    </li>
                    <?php
                  } // Show if not first page
                    ?>
                <?php if ($pageNum_Recordset1 > 0)
                  { // Show if not first page2
                    ?>
                    <li>
                      <a href="<?php printf('%s?pageNum_Recordset1=%d%s', $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Précédent</a>
                    </li>
                    <?php
                  } // Show if not first page
                  ?>
                <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page
                 ?>
                <li><a href="<?php printf('%s?pageNum_Recordset1=%d%s', $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1);
                  ?>">Suivant</a></li>
                <?php }// Show if not last page
                ?>
                <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page
                ?>
                <li><a href="<?php printf('%s?pageNum_Recordset1=%d%s', $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Dernier</a></li>
                <?php } // Show if not last page
                ?>
              </ul>
              <ul class="pagination visible-xs pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">»</a></li>
              </ul>
            </div>
          </div>


        </div>
      </div>
      </div>
      </div>
      </div>
</body>

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
</html>
<?php mysql_free_result($Recordset1); ?>