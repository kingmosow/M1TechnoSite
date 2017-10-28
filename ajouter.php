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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $insertSQL = sprintf("INSERT INTO etudiants (prenoms, nom, login, mdp, adresse, telephone, email) VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['prenoms'], "text"),
        GetSQLValueString($_POST['nom'], "text"),
        GetSQLValueString($_POST['login'], "text"),
        GetSQLValueString($_POST['mdp'], "text"),
        GetSQLValueString($_POST['adresse'], "text"),
        GetSQLValueString($_POST['telephone'], "text"),
        GetSQLValueString($_POST['email'], "text"));

    mysql_select_db($database_cnx, $cnx);
    $Result1 = mysql_query($insertSQL, $cnx) or die(mysql_error());

    $insertGoTo = "admin.php?msg=Nouveau Etudiant ajouté";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
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
<!--    <link rel="stylesheet" type="text/css" href="public/css/messtyles.css">-->

    <!--  <link rel="stylesheet" type="text/css" href="bootstrap/css/messtyles.css">-->
    <title>Page d'ajout</title>


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
            <h3 class="alert alert-info" style="margin-top: 5%; text-align: center;">Page d'ajout d'un étudiant</h3>

            <div class="well col-md-8 center-block " style="margin-left: 10%">

                <div class="form-group ">
                    <input size="60" maxlength="255" class="form-control" placeholder="Prenom" name="prenoms"type="text">
                </div>
                <div
                <div class="form-group ">
                    <input size="60" maxlength="255" class="form-control" placeholder="Nom" name="nom"type="text" >
                </div>

                <div class="form-group">
                    <input size="60" maxlength="255" class="form-control" placeholder="Login" name="login"type="text" >
                </div>
                <div class="form-group ">
                    <input size="60" maxlength="255" class="form-control" placeholder="Password" name="mdp" type="password">
                </div>
                <div class="form-group ">
                    <input size="60" maxlength="255" class="form-control" placeholder="Adresse" name="adresse" id="UserRegistration_address" type="text" >
                </div>

                <div class="form-group ">
                    <input size="60" maxlength="255" class="form-control" placeholder="Numero de Téléphone" name="telephone" type="text" >
                </div>
                <div class="form-group">
                    <input size="60" maxlength="255" class="form-control" placeholder="Email" name="email" id="UserRegistration_address" type="text" >
                </div>

                <button  type="submit" id="submit" name="submit" class="btn btn-primary pull-right" value="form1">Valider </button>

                <input type="hidden" name="MM_insert" value="form1">
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
