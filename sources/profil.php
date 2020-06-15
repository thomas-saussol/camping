<html>

<head>
	<title> Faites votre réservation</title>
	<link href="camping.css" rel="stylesheet">
	<link rel="icon" href="../img/sardine.jpg">
</head>




<body class="profil">

<header>
	<ul>
		<li><a href="../index.php">Accueil</a></li>
	</ul>			
</header>



<?php
session_start();



if(!isset($_SESSION['login']))
{
		header('Location: connexion.php');
}


$user=$_SESSION['login'];
$base=mysqli_connect("localhost", "root", "", "camping");
mysqli_set_charset($base, "utf8");
$reqadmin="SELECT grade FROM utilisateurs where login='$user'";
$resultadmin=mysqli_query($base, $reqadmin);
$admin=mysqli_fetch_array($resultadmin);


if($admin['grade']=="admin")
{
	$reqreserv="SELECT *FROM reservations";
	$reqdates="SELECT date_debut, date_fin FROM reservations ";
	$dates=mysqli_query($base, $reqdates);
	$mesdates=mysqli_fetch_all($dates);	
}
else
{
$reqreserv="SELECT *FROM reservations where utilisateur='$user'";
$reqdates="SELECT date_debut, date_fin FROM reservations where utilisateur='$user'";
$dates=mysqli_query($base, $reqdates);
$mesdates=mysqli_fetch_all($dates);
}


$reserv=mysqli_query($base, $reqreserv);
$existbdd=mysqli_num_rows($reserv);

if($existbdd > 0)
{
?>

<div class="mesreserv">
	<table>
		<tr>
			<th>Nom</th>
			<th>Emplacement</th>
			<th>Date de début</th>
			<th>Date de Fin</th>
			<th>Type</th>
			<th>Bornes Electrique</th>	
			<th>Accès Disco</th>	
			<th>Packs d'activités</th>	
			<th>Prix total</th>
			
		</tr>
		

<?php
$j=0;

while($mareserv=mysqli_fetch_array($reserv))
{
$_SESSION['prix']=[];
echo '<tr>';
switch ($mareserv['id_emplacements']){

		case 1:
		$mareserv['id_emplacements']="La Plage";
		break;
		
		case 2:	
		$mareserv['id_emplacements']="Les Pins";
		break;
		
		case 3:
		$mareserv['id_emplacements']="Les Pins";
		break;
		
}


switch ($mareserv['type']){

		case 1:
		$mareserv['type']="Tente";
		break;
		
		case 2:	
		$mareserv['type']="Camping Car";
		break;
}

if($mareserv['Bornes']==1)
{
	
	$reqprix1="SELECT prix FROM tarifs where nom='Bornes'";
	$prix1=mysqli_query($base, $reqprix1);
	$monprix1=mysqli_fetch_array($prix1);
	array_push($_SESSION['prix'], $monprix1['prix']);
	

	$mareserv['Bornes']="Oui";
}
else
{
	$mareserv['Bornes']="Non";
}

if($mareserv['Disco']==1)
{
	$reqprix2="SELECT prix FROM tarifs where nom='Disco'";
	$prix2=mysqli_query($base, $reqprix2);
	$monprix2=mysqli_fetch_array($prix2);
	array_push($_SESSION['prix'], $monprix2['prix']);
	$mareserv['Disco']="Oui";
}
else
{
	$mareserv['Disco']="Non";
}

if($mareserv['Packs Activités']==1)
{
	$reqprix3="SELECT prix FROM tarifs where nom='Packs Activités'";
	$prix3=mysqli_query($base, $reqprix3);
	$monprix3=mysqli_fetch_array($prix3);
	array_push($_SESSION['prix'], $monprix3['prix']);
	$mareserv['Packs Activités']="Oui";
}
else
{
	$mareserv['Packs Activités']="Non";
}

echo '<td>';
echo $mareserv['Nom'];	
echo '</td>';	

echo '<td>';
echo $mareserv['id_emplacements'];	
echo '</td>';

echo '<td>';
echo $mareserv['date_debut'];	
echo '</td>';

echo '<td>';
echo $mareserv['date_fin'];	
echo '</td>';

echo '<td>';
echo $mareserv['type'];	
echo '</td>';

echo '<td>';
echo $mareserv['Bornes'];	
echo '</td>';

echo '<td>';
echo $mareserv['Disco'];	
echo '</td>';

echo '<td>';
echo $mareserv['Packs Activités'];	
echo '</td>';






$debut=date_create($mesdates[$j][0]);
$fin=date_create($mesdates[$j][1]);

$calcul=date_timestamp_get($fin) - date_timestamp_get($debut); 
$nbrjour=$calcul / 86400;
$a=$nbrjour*10;
for($i=0; $i < sizeof($_SESSION['prix']); $i++)
{

$a=$a+$_SESSION['prix'][$i];
}

echo '<td>';
echo $a.' €';
echo '</td>';

echo '</tr>';





// array_push($_SESSION['jour'], $nbrjour);
// print_r($_SESSION['jour']); 


unset($_SESSION['jour']);
unset($_SESSION['prix']);
$j=$j+1;

}
}
else
{
	echo "Aucune réservation effectuée";
}
?>
		
		
	</table>
</div>




</body>