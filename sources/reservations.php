<html>

<head>
	<title> Faites votre réservation</title>
	<link href="camping.css" rel="stylesheet">
	<link rel="icon" href="../img/sardine.jpg">
</head>


<header>
	<ul>
		<li><a href="../index.php">Accueil</a></li>
	</ul>			
</header>


<?php session_start(); 

if(!isset($_SESSION['login']))
{
		header('Location: connexion.php');
}

if(isset($_POST['valid'])) 
{
if( !empty($_POST['type']) && !empty($_POST['nom']))
{	
	// PACK-----------------------
	
	if(!empty($_POST['scales1']))
	{
	$option1=1;

	}
	else
	{
	$option1=0;	
	}
	if(!empty($_POST['scales2']))
	{
	$option2=1;
	}
	else
	{
	$option2=0;	
	}
	if(!empty($_POST['scales3']))
	{
	$option3=1;
	}
	else
	{
	$option3=0;	
	}
	
	


$_SESSION['type']=$_POST['type'];
$_SESSION['nom']=$_POST['nom'];

if(!empty($_POST['scales1']))
{
$_SESSION['scales1']=1;
}
else
{
$_SESSION['scales1']=0;
}	
if(!empty($_POST['scales2']))
{
$_SESSION['scales2']=1;
}
else
{
$_SESSION['scales2']=0;	
}
if(!empty($_POST['scales3']))
{
$_SESSION['scales3']=1;
}
else
{
$_SESSION['scales3']=0;	
}




}
}

if(isset($_POST['emplacement']))
	{
		$_SESSION['emplacement']=$_POST['emplacement'];
	}
?>
		



<body class="<?php if(isset($_SESSION['emplacement'])){$lieu = str_replace(' ', '', $_SESSION['emplacement']); echo $lieu;}?>">



<?php

if((isset($_POST['jour']))||(isset($_POST['jour2'])))
{

switch ($_POST['mois']){
	
	case "Janvier":
	$mois="01";
	break;
	
	case "Février":
	$mois="02";
	break;
	
	case "Mars":
	$mois="03";
	break;
	
	case "Avril":
	$mois="04";
	break;
	
	case "Mai":
	$mois="05";
	break;
	
	case "Juin":
	$mois="06";
	break;
	
	case "Juillet":
	$mois="07";
	break;
	
	case "Août":
	$mois="08";
	break;
	
	case "Septembre":
	$mois="09";
	break;
	
	case "Octobre":
	$mois="10";
	break;
	
	case "Novembre":
	$mois="11";
	break;
	
	case "Décembre":
	$mois="12";
	break;
	}
	

	if(isset($_POST['jour']))
	{
	$date=$_POST['annee']."-".$mois."-".$_POST['jour'];
	$_SESSION['date_debut']=$date;
	}
	if (isset($_POST['jour2']))
	{
	$date2=$_POST['annee']."-".$mois."-".$_POST['jour2'];
	$_SESSION['date_fin']=$date2;	
	}
	
}



$base= mysqli_connect("localhost", "root", "", "camping");

if(isset($_POST['back']))
{
	
	unset($_SESSION['emplacement']);
	unset($_SESSION['date_debut']);
	unset($_SESSION['date_fin']);
	unset($_SESSION['taille']);
	
	unset($_SESSION['type']);
	unset($_SESSION['nom']);
	unset($_SESSION['scales1']);
	unset($_SESSION['scales2']);
	unset($_SESSION['scales3']);
	
	?><meta http-equiv="refresh" content="0;URL=reservations.php"><?php
}

if((!isset($_POST['emplacement']))&&(!isset($_SESSION['emplacement'])))
{
?>

<section class="Reservations">


<div id="plage">
	<form method="post" action="reservations.php">
		<input name="emplacement" type="submit" value="La Plage">
	</form>
</div>
<div id="pins">
	<form method="post" action="reservations.php">
		<input name="emplacement" type="submit" value="Les Pins">
	</form>
</div>
<div id="maquis">
	<form method="post" action="reservations.php">
		<input name="emplacement" type="submit" value="Le Maquis">
	</form>
</div>


</section>
<?php

}
else
{
		// AFFICHAGE DE NOMBRE D'EMPLACEMENTSRESTANT(S)
		
		
		
		
			

?>
<h1 id="titre"><?php echo  $_SESSION['emplacement']; ?></h1>
<?php
if(isset($_SESSION['erreur']))
{
?>
	<div class="erreurreserv"><p>*Dates non disponibles</p></div>
<?php
	unset($_SESSION['erreur']);
}

if(isset($_SESSION['nondate']))
{
?>
	<div class="erreurreserv"><p>Veuillez choisir vos dates de séjour</p></div>
<?php
	unset($_SESSION['nondate']);
}
?>

<section class="choixreservations">
<div class="mareservation">
<div class="option">
	
	<form method="post" action="reservations.php">

	<?php if(!isset($_SESSION['type'])&& !isset($_SESSION['nom']))
	{  
	
		if(isset($_POST['valid']) && !isset($_POST['name']))
		{
		?>	
		<p class="noname2">*Veuillez entrer un nom de réservation</p>
		<input class="name2" type="text" name="nom"  placeholder="* Nom de la réservation" >				
		<?php
		}
		else
		{
		?>
		<input class="name" type="text" name="nom"  placeholder="* Nom de la réservation" >
		<?php
		}
		?>

		<br>
		<select class="type" name="type">
			<option  value="1">Tente (1 emplacement)</option>
			<option  value="2">Camping-Car (2 emplacements)</option>
		</select>
	<?php
	}
	else
	{
	?>
		<input class="name" disabled placeholder="<?php echo $_SESSION['nom'];?>" name="nom" type="text">
		<br>
		<select class="type" name="type">
			<option value="1"><?php if($_SESSION['type']==1){echo "Tente (1 emplacement)";}else{ echo "Camping-Car (2 emplacements)";}?></option>
		</select>
	<?php
	}
		$base=mysqli_connect("localhost", "root", "", "camping");
		mysqli_set_charset($base, "utf8");
		$reqtarifs="SELECT *FROM tarifs";
		$tarifs=mysqli_query($base, $reqtarifs);
		$nostarifs=mysqli_fetch_all($tarifs);

	?>
	
		<br><br>
		<label id="size">Options supplémentaires :</label><br>
		<?php
		
		$text="scales";
		for($i=0; $i < sizeof($nostarifs); $i++)
		{
		$j=$i+1;
		$options=$text.''.$j;	
		?>
		
		<?php
		if($i==2)
		{
		?>
			<label><?php echo $nostarifs[$i][1].' '.'( '.$nostarifs[$i][2].' € )'.' '.'Yoga, Frisbee, Ski Nautique';?></label>
			<input <?php if(isset($_SESSION[$options])){ if($_SESSION[$options]==1){ ?> checked <?php }}?> type="checkbox" id="scales" name=
			"scales<?php echo $j;?>" value="bornes">
			<br>
		<?php
		}
		else
		{
		?>
			<label><?php echo $nostarifs[$i][1].' '.'( '.$nostarifs[$i][2].' € )';?></label>
			<input <?php if(isset($_SESSION[$options])){ if($_SESSION[$options]==1){ ?> checked <?php }}?> type="checkbox" id="scales" name=
			"scales<?php echo $j;?>" value="bornes">
			<br>
		<?php 
		}
		}		
		?>
		
		
		
		

		<?php if(!isset($_SESSION['type']))
		{
		?>
		<input class="reserv" type="submit" name="valid" value="Suivant">	
		<?php
		}
		else
		{
		?>
		<input class="reserv" type="submit" name="valider" value="Valider">	
		<?php
		}
		?>
		<input class="reserv" type="submit" name="back" value="Retour">	
	</form>
	
	
</div>
	<div class="calendrier">
		<?php include("calendrier.php");?>
	</div>
</div>
<section>

<?php
	
}


if(isset($_POST['valider']))
{
	if(!isset($_SESSION['date_debut']) || !isset($_SESSION['date_fin']))
	{
		$_SESSION['nondate']=true;
		?><meta http-equiv="refresh" content="0;URL=reservations.php"><?php
	}
	else
	{


$type=$_SESSION['type'];

$base= mysqli_connect("localhost", "root", "", "camping");
$req="SELECT type, date_debut, date_fin FROM reservations WHERE id_emplacements='$idemplacement'";
$result=mysqli_query($base, $req);
$dates=mysqli_fetch_all($result);



$date1 = date_create($_SESSION['date_debut']);
$date2= date_create($_SESSION['date_fin']);	
					
						
$place=0;

for($k=0; $k < sizeof($dates); $k++)
{
$date_debut=date_create($dates[$k][1]);
$date_fin=date_create($dates[$k][2]);

	if((date_timestamp_get($date2)>=date_timestamp_get($date_debut))&&(date_timestamp_get($date1) <= date_timestamp_get($date_debut)))
	{
	$place=$place+$dates[$k][0];

	}
}
echo $place;

if($place > 4)
{
		$_SESSION['erreur']=true;
		?><meta http-equiv="refresh" content="0;URL=reservations.php"><?php		
}
else
{
	$login=$_SESSION['login'];
	$scales1=$_SESSION['scales1'];
	$scales2=$_SESSION['scales2'];
	$scales3=$_SESSION['scales3'];
	$debut=$_SESSION['date_debut'];
	$fin=$_SESSION['date_fin'];
	$nom=$_SESSION['nom'];
	
	
	$reservation="INSERT INTO reservations VALUES (NULL, '".$debut."', '".$fin."', '".$type."', '".$scales1."', '".$scales2."', '".$scales3."', '".$idemplacement."', '".$nom."',
	'".$login."')";
	mysqli_query($base, $reservation);
	mysqli_close($base);
	
	unset($_SESSION['emplacement']);
	unset($_SESSION['date_debut']);
	unset($_SESSION['date_fin']);
	unset($_SESSION['taille']);
	
	unset($_SESSION['type']);
	unset($_SESSION['nom']);
	unset($_SESSION['scales1']);
	unset($_SESSION['scales2']);
	unset($_SESSION['scales3']);
	
	?><meta http-equiv="refresh" content="0;URL=reservations.php"><?php
	
	
}
}	
}

?>