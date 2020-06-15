<html>

<?php
session_start();

if(!isset($_SESSION['login']))
{
?>
<head>
	<link href="camping.css" rel="stylesheet">
	<title>Inscription</title>
	<meta charset="UTF-8">
</head>

<body class="inscription">

<header>
	<ul>
		<li><a href="../index.php">Accueil</a></li>
	</ul>
</header>


  
<?php
// --------------------------------------------DEBUT PHP--------------------------------------------

if(isset($_POST['Valider']))
{
	$connexion= mysqli_connect("localhost", "root", "", "camping");
	$login=$_POST['field1'];
	$req="SELECT  *from utilisateurs WHERE login='$login'";
    $query=mysqli_query($connexion, $req) or die(mysqli_error($connexion));
    $result=mysqli_num_rows($query);

	if((($_POST['field2']!=$_POST['field3'])||($result>0))||(strlen($_POST['field2'])< 5))
	{
		if(($_POST['field2']!=$_POST['field3'])&&($result>0))
		{
			?>
			<div class="erreur">
			<div class="affichage">
			<?php
			echo"*Mots de passes rentrés différents";
			?>
			</div>
			<div class="affichage">
			<?php
			echo"*Veuillez renseigner un autre login";
			mysqli_close($connexion);
			?>
			</div>
			</div>
			<?php
		}
		else if((strlen($_POST['field2'])< 5)&&($result>0))
		{
			?>
			<div class="erreur">
			<div class="affichage">
			<?php
			echo"*Veuillez renseigner un autre login";
			?>
			</div>
			<div class="affichage">
			<?php
			echo"*Mots de passes trop courts";
			echo" 5 caractères minimum";
			mysqli_close($connexion);
			?>
			</div>
			</div>
			<?php
		}
		else if($result>0)
		{
			?>
			<div class="erreur">
			<div class="affichage">
			<?php
			echo "*Veuillez renseigner un autre login";
			?>
			</div>
			</div>
			<?php
			mysqli_close($connexion);
		}
		else if($_POST['field2']!=$_POST['field3'])
		{
			?>
			<div class="erreur">
			<div class="affichage">
			<?php
			echo"*Mots de passes rentrés différents";
			mysqli_close($connexion);
			?>
			</div>
			</div>
			<?php
		}
		else if(strlen($_POST['field2']< 5))
		{
			?>
			<div class="erreur">
			<div class="affichage">
			<?php
			echo"*Mots de passes trop courts";
			echo " 5 caractères minimum";
			mysqli_close($connexion);
			?>
			</div>
			</div>
			<?php
		}
	}
	else
	{

			$hash = password_hash($_POST['field2'], PASSWORD_BCRYPT, ['cost' => 12]);
			$connexion= mysqli_connect("localhost", "root", "", "camping");
			$req2 = 'INSERT INTO `utilisateurs`(`login`,`password`)VALUES
			("'.$_POST['field1'].'", "'.$hash.'");';
			mysqli_query($connexion, $req2);
			mysqli_close($connexion);
			header('Location: connexion.php');


	}
}
// --------------------------------------------FIN PHP--------------------------------------------
?>




<div class="form-style-5">
		<form method="post" action="inscription.php">
		<fieldset>
		<legend>Inscrivez-vous</legend>
		<div class="input">
		<input required type="text" name="field1" placeholder="Login *">
		</div>
		<div class="input">
		<input required type="password" name="field2" placeholder="Password *">
		</div>
		<div class="input">
		<input required type="password" name="field3" placeholder="Confirm Password *">
		</div>
		<div class="input">
		<input type="submit" name="Valider" value="S'INSCRIRE"/>
		</div>
		</fieldset>
		</form>
</div>



</body>

<?php
}
else
{
	header('location: ../index.php');
}
?>

</html>
