<html>

<head>
	<title>Les Happy Sardines</title>
	<link href="sources/camping.css" rel="stylesheet">
	<link rel="icon" href="img/sardine.jpg">
</head>

<?php session_start();

if(isset($_POST['deco']))
{
unset($_SESSION['login']);	
}
?>

<body class="accueil" id="page-top">




<?php
if(isset($_SESSION['login']))
{
	$login=$_SESSION['login'];
	$base=mysqli_connect("localhost", "root", "", "camping");
	$reqgrade="SELECT grade FROM utilisateurs WHERE login='$login'";
	$grade=mysqli_query($base, $reqgrade);
	$mongrade=mysqli_fetch_array($grade);
}
?>




<ul>
	<?php if(!isset($_SESSION['login']))
	{
	?>
	<div>
		<li><a href="sources/inscription.php">Inscription</a></li>
		<li><a href="sources/connexion.php">Connexion</a></li>
	</div>
	<?php
	}
	else if($mongrade['grade']=="admin")
	{
	?>
		<div class="row">
		<form class="deco" action="index.php" method="post">
			<input name="deco" type="submit" value="Déconnexion">
		</form>	
		<li><a href="sources/administration.php">Tarifs</a></li>
		<li><a href="sources/profil.php">Réservations</a></li>
		</div>
	<?php
	}
	else 
	{
	?>
		<div class="row">
		<form class="deco" action="index.php" method="post">
			<input name="deco" type="submit" value="Déconnexion">
		</form>
		<li><a href="sources/profil.php">Mes réservations</a></li>	
		</div>
	<?php
	}
	?>
	<div>
		<li><a href="sources/reservations.php">Réservation</a></li>
		<li><a href="#page-top">Accueil</a></li>
	</div>
</ul>



<!--Header-->

<div class="container" >
	<div class="about">	
		<a href="#about"><h1>En savoir plus</h1></a>
	</div>
</div>



<!--About-->

<div  id="about" class="container2">
	<h2>Notre Camping</h2>
		<div class="lesplus">
			<div><img src="img/label.png" >
				<p>Camping Qualité, le label qualité</p>
				<p>des campings en France</p>
			</div>
			<div><img src="img/arbre.png">
				<p>Un environement agréable et</p>
				<p>sain au coeur de la nature</p>
			</div>
			<div><img src="img/sport.png">
				<p>Diverses activitées proposées</p>
				<p>Pour vous ou vos enfants</p>
			</div>
		</div>
</div>

<!--HR-->

<div class="hr">
	<hr>
</div>


<div class="titre2">
	<h2>Quelques photos</h2>
		<div class="container3">
			<div><img src="img/photocamping1.jpg"></div>
			<div><img src="img/photocamping2.jpg"></div>
			<div><img src="img/photocamping3.jpg"></div>
			<div><img src="img/photocamping4.jpg"></div>
		</div>
</div>


<footer>

<p>Les Happy Sardines ©</p>
</footer>







</body>
</html>