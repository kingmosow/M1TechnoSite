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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $updateSQL = sprintf("UPDATE etudiants SET prenoms=%s, nom=%s, login=%s, mdp=%s, adresse=%s, telephone=%s, email=%s WHERE id=%s",
        GetSQLValueString($_POST['prenoms'], "text"),
        GetSQLValueString($_POST['nom'], "text"),
        GetSQLValueString($_POST['login'], "text"),
        GetSQLValueString($_POST['mdp'], "text"),
        GetSQLValueString($_POST['adresse'], "text"),
        GetSQLValueString($_POST['telephone'], "text"),
        GetSQLValueString($_POST['email'], "text"),
        GetSQLValueString($_POST['id'], "int"));

    mysql_select_db($database_cnx, $cnx);
    $Result1 = mysql_query($updateSQL, $cnx) or die(mysql_error());

    $updateGoTo = "admin.php?msg=Modification reussi";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['recordID'])) {
    $colname_Recordset1 = $_GET['recordID'];
}
mysql_select_db($database_cnx, $cnx);
$query_Recordset1 = sprintf("SELECT * FROM etudiants WHERE id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $cnx) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
    <!--  <link rel="stylesheet" type="text/css" href="bootstrap/css/messtyles.css">-->
    <title>Page D'edition</title>
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top" >
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topFixedNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <a class="navbar-brand" href="index.php" style="color:#FFF">Accueil</a></div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="topFixedNavbar1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="admin.php">Admin<span class="sr-only">(current)</span></a></li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Session<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php">Se deconnecter</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<div class="container">

        <div class="form-area">
            <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                <br style="clear:both">
                <h3 class="alert alert-info" style="margin-top: 5%; text-align: center;">Page de modification étudiant</h3>

                <div class="well col-md-8 center-block" style="margin-left: 10%">

                    <div class="form-group ">
                        <input size="60" maxlength="255" class="form-control" placeholder="Prenom" name="prenoms"type="text" value="<?php echo htmlentities($row_Recordset1['prenoms'], ENT_COMPAT, 'utf-8'); ?>">                                                           </div>
                    <div
                    <div class="form-group ">
                        <input size="60" maxlength="255" class="form-control" placeholder="Nom" name="nom"type="text" value="<?php echo htmlentities($row_Recordset1['nom'], ENT_COMPAT, 'utf-8'); ?>">
                    </div>

                    <div class="form-group">
                        <input size="60" maxlength="255" class="form-control" placeholder="Login" name="login"type="text" value="<?php echo htmlentities($row_Recordset1['login'], ENT_COMPAT, 'utf-8'); ?>">                                                       					                                       </div>
                    <div class="form-group ">
                        <input size="60" maxlength="255" class="form-control" placeholder="Password" name="mdp" type="password">                                    </div>
                    <div class="form-group ">
                        <input size="60" maxlength="255" class="form-control" placeholder="Adresse" name="adresse" id="UserRegistration_address" type="text" value="<?php echo htmlentities($row_Recordset1['adresse'], ENT_COMPAT, 'utf-8'); ?>">                                    </div>

                    <div class="form-group ">
                        <input size="60" maxlength="255" class="form-control" placeholder="Numero de Téléphone" name="telephone" type="text" value="<?php echo htmlentities($row_Recordset1['telephone'], ENT_COMPAT, 'utf-8'); ?>">                                                                  </div>
                    <div class="form-group">
                        <input size="60" maxlength="255" class="form-control" placeholder="Email" name="email" id="UserRegistration_address" type="text" value="<?php echo htmlentities($row_Recordset1['email'], ENT_COMPAT, 'utf-8'); ?>">                                    </div>

                    <button  type="submit" id="submit" name="submit" class="btn btn-primary pull-right">Valider </button>

                    <input type="hidden" name="MM_update" value="form1">
                    <input type="hidden" name="id" value="<?php echo $row_Recordset1['id']; ?>">
                </div>
            </form>

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

</html>
<?php
mysql_free_result($Recordset1);
?>
