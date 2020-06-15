<?php

session_start();



?>


<html>

<head>
	<title>Les Happy Sardines</title>
	<link href="camping.css" rel="stylesheet">
	<link rel="icon" href="../img/sardine.jpg">
</head>


<body class="administration">

<header>
	<ul>
		<li><a href="../index.php">Accueil</a></li>
	</ul>			
</header>

<?php
$user=$_SESSION['login'];
$base=mysqli_connect("localhost", "root", "", "camping");
mysqli_set_charset($base, "utf8");
$reqadmin="SELECT grade FROM utilisateurs where login='$user'";
$resultadmin=mysqli_query($base, $reqadmin);
$admin=mysqli_fetch_array($resultadmin);

if($admin['grade']!="admin")
{
		header('Location: ../index.php');
}

$reqtarifs="SELECT *FROM tarifs";
$tarifs=mysqli_query($base, $reqtarifs);


if(isset($_POST['Valider']))
{
$nom=explode ( ' ', $_POST['field1']);
$prix=$_POST['field2'];
$nouveauprix="UPDATE tarifs SET prix = '$prix' WHERE nom='$nom[0]'";
mysqli_query($base, $nouveauprix);
mysqli_close($base);

?><meta http-equiv="refresh" content="0;URL=administration.php"><?php

}

?>


<section>
	<div class="form-style-5">
		<form method="post" action="administration.php">
			<fieldset>
			<legend>Nos tarifs</legend>	
			<div class="input">
				<select required  name="field1">
			<option value="">Chosir l'option</option>
			<?php while($nostarifs=mysqli_fetch_array($tarifs))
			{
			?>
			<option><?php echo $nostarifs['nom'].' '. '( '.$nostarifs['prix'].' € )'; ?></option>			
			<?php
			}
			?>
			</select>	
			</div>
			<div class="input">
			<input required type="number" name="field2" placeholder="Nouveau prix">
			</div>
			<div class="input">
			<input type="submit" name="Valider" value="VALIDER"/>
			</div>
			</fieldset>
		</form>
	</div>
</section>	










</body>
</html>