<html>


<head>
	<link href="camping.css" rel="stylesheet">
	<title>Connexion</title>
	<meta charset="UTF-8">
</head>

<body class="connexion">

<header>

<ul>
				<li><a href="../index.php">Accueil</a></li>
				<li><a href="inscription.php">Inscription</a></li>
</ul>

</header>

  

<?php
// --------------------------------------------DEBUT PHP--------------------------------------------
session_start();

if(!isset($_SESSION['login']))
{
if((isset($_POST['Valider']))&&(isset($_POST['field1']))&&(isset($_POST['field2'])))
{

	$connexion= mysqli_connect("localhost", "root", "", "camping");
	$login=$_POST['field1'];
	$query="SELECT *from utilisateurs WHERE login='$login'";
	$result= mysqli_query($connexion, $query);
	$row = mysqli_fetch_array($result);

	if(password_verify($_POST['field2'],$row['password']))
	{
	$_SESSION['login'] = $_POST['field1'];
	$_SESSION['password'] = $_POST['field2'];
	header ('location: ../index.php');
	}
	else
	{
	?>
	<div class="erreur">
	<div class="affichage">
	<?php
	echo "*Login ou mot de passe incorrect";
	?>
	</div>
	</div>
	<?php
	}
}

// --------------------------------------------FIN PHP--------------------------------------------
?>

<section>
	<div class="form-style-5">
		<form method="post" action="connexion.php">
			<fieldset>
			<legend>Connexion</legend>
			<div class="input">
			<input required type="text" name="field1" placeholder="Login *">
			</div>
			<div class="input">
			<input required type="password" name="field2" placeholder="Password *">
			</div>
			<div class="input">
			<input type="submit" name="Valider" value="SE CONNECTER"/>
			</div>
			</fieldset>
		</form>
	</div>
</section>

<?php
}
else
{
	header('location: ../index.php');
}
?>
</body>


</html>
