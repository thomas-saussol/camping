<?php

$retour = $_SERVER["REQUEST_URI"];
if($retour === '/camping/sources/calendrier.php')
{
    header("Location: reservations.php");
}
// --------------EMPLACEMENTS---------------

	if($_SESSION['emplacement']=="La Plage")
	{
		$idemplacement=1;
	}
	else if($_SESSION['emplacement']=="Les Pins")	
	{
		$idemplacement=2;	
	}
	else if($_SESSION['emplacement']=="Le Maquis")	
	{
		$idemplacement=3;	
	}
	
	
$base= mysqli_connect("localhost", "root", "", "camping");
$req="SELECT date_debut, type FROM reservations WHERE id_emplacements='$idemplacement'";
$result=mysqli_query($base, $req);
$resultat=mysqli_fetch_all($result);


$a=0;
for($j=0; $j < sizeof($resultat); $j++)
{
	$a = $a+$resultat[$j][1][0];
}

if(isset($_SESSION['type']))
{

$_SESSION['taille']=$a;


if (!isset($_GET['mois']) && !isset($_GET['annee']))
{
	$calendrier_date_mois = date('n');
	$calendrier_date_annee = date('Y');
}
else
{
	$calendrier_date_mois = $_GET['mois'];
	$calendrier_date_annee = $_GET['annee'];
}

/* Ici on calcul le passage à l'année précédente. */
if ($calendrier_date_mois == '1')
{
	$calendrier_date_mois_precedent = '12';
	$calendrier_date_annee_precedente = $calendrier_date_annee - 1;
}
else 
{
	$calendrier_date_mois_precedent = $calendrier_date_mois - 1;
	$calendrier_date_annee_precedente = $calendrier_date_annee;
}

/* Et ici on calcul le passage à l'année suivante. */
if ($calendrier_date_mois == '12')
{
	$calendrier_date_mois_suivant  = '1';
	$calendrier_date_annee_suivante  = $calendrier_date_annee + 1;
}
else 
{
	$calendrier_date_mois_suivant  = $calendrier_date_mois + 1;
	$calendrier_date_annee_suivante = $calendrier_date_annee;
}


$calendrier_dateDuJour = date('j_n_Y'); 



$calendrier_dates_importantes = array(	'1_6_2020	', 
										'5_6_2020', 
								       '15_8_2020',
									   '14_7_2020',
									   '20_7_2020',
									    '1_1_2020');

/* le mktime retourne les info d'une date donnée */
$calendrier_mktime = mktime(0, 0, 0, $calendrier_date_mois, 1, $calendrier_date_annee);



$calendrier_date_mois_1erjour = date('w', $calendrier_mktime);


$calendrier_date_mois_nombrejour = date('t', $calendrier_mktime);



$calendrier_mois = array( '1' => 'Janvier',   '2' => 'Février',   '3' => 'Mars', 
						  '4' => 'Avril',     '5' => 'Mai',       '6' => 'Juin',
						  '7' => 'Juillet',   '8' => 'Août',      '9' => 'Septembre', 
					     '10' => 'Octobre',  '11' => 'Novembre', '12' => 'Décembre');
?>

<html>
<head>


<title>Calendrier - floptwo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php 


if ($calendrier_date_mois.'_'.$calendrier_date_annee == date('n_Y'))
{
	$class_mois = 'calendrier_mois_encours';
}
else
{
	$class_mois = 'calendrier_mois';
}
?>
<table class="calendrier" width="200" border="0" align="center" cellpadding="1" cellspacing="1"> 
 <tr align="center" valign="middle">
<?php
if(!isset($_GET['mois2']))
{
?>

    <td><?php echo '<a href="?mois=' , $calendrier_date_mois_precedent , '&annee=' , $calendrier_date_annee_precedente , '" class="calendrier_mois"><img src="../img/flechegauche.png" width="60%"></a>'?></td>
	<td colspan="5" class="<?php echo $class_mois ?>"><?php echo $calendrier_mois[$calendrier_date_mois],' ',$calendrier_date_annee ?></td>
    <td><?php echo '<a href="?mois=' , $calendrier_date_mois_suivant , '&annee=' , $calendrier_date_annee_suivante , '" class="calendrier_mois"><img src="../img/flechedroite.png" width="60%"></a>'?></td>
<?php

}
else
{
?>
	<td><?php echo '<a href="?mois2=' ,$_GET['mois2'] , '&annee2=' ,$_GET['annee2'], '&mois=' , $calendrier_date_mois_precedent , '&annee=' , $calendrier_date_annee_precedente , '" class="calendrier_mois"><img src="../img/flechegauche.png" width="60%"></a>'?></td>
	<td colspan="5" class="<?php echo $class_mois ?>"><?php echo $calendrier_mois[$calendrier_date_mois],' ',$calendrier_date_annee ?></td>
	<td><?php echo '<a href="?mois2=' ,$_GET['mois2'] , '&annee2=' ,$_GET['annee2'], '&mois=' , $calendrier_date_mois_suivant , '&annee=' , $calendrier_date_annee_suivante , '" class="calendrier_mois"><img src="../img/flechedroite.png" width="60%"></a>'?></td>
<?php
}
?>	
 
  </tr>
  <tr> 
    <td class="calendrier_nom_des_jours">Lun</td>
    <td class="calendrier_nom_des_jours">Mar</td>
    <td class="calendrier_nom_des_jours">Mer</td>
    <td class="calendrier_nom_des_jours">Jeu</td>
    <td class="calendrier_nom_des_jours">Ven</td>
    <td class="calendrier_nom_des_jours">Sam</td>
    <td class="calendrier_nom_des_jours">Dim</td>
  </tr>
  <?php

			
$calendrier_compteur_jours = 00;

// -----------REQUETE POUR SELECTIONER DANS LA BDD TOUTES LES DATES DE DEBUT DE RESERVATION DEJA CHOISIE(S)--------------

$req_date_debut="SELECT date_debut, type, id FROM reservations WHERE id_emplacements='$idemplacement'";
$result_date_debut=mysqli_query($base, $req_date_debut);
$date_debut=mysqli_fetch_all($result_date_debut);

// -----------REQUETE POUR SELECTIONER DANS LA BDD TOUTES LES DATES DE FIN DE RESERVATION DEJA CHOISIE(S)--------------

$type=$_SESSION['type'];
$base= mysqli_connect("localhost", "root", "", "camping");
$req_date_fin="SELECT date_fin FROM reservations WHERE id_emplacements='$idemplacement'";
$result_date_fin=mysqli_query($base, $req_date_fin);
$date_fin=mysqli_fetch_all($result_date_fin);




if(isset($_GET['mois']))
{
if(isset($_GET['mois2']))
{
?>
<form action="reservations.php?mois2=<?php echo $_GET['mois2'];?>&annee2=<?php echo $_GET['annee2'];?>&mois=<?php echo $_GET['mois'];?>&annee=<?php echo $_GET['annee'];?>" method="post">
<?php
}
else
{
?>
<form action="reservations.php?mois=<?php echo $_GET['mois'];?>&annee=<?php echo $_GET['annee'];?>" method="post">	
<?php
}
}
else if(isset($_GET['mois2']))
{
?>
<form action="reservations.php?mois2=<?php echo $_GET['mois2'];?>&annee2=<?php echo $_GET['annee2'];?>" method="post">
<?php
}
else
{
?>
<form action="reservations.php" method="post">	
<?php
}


while ($calendrier_compteur_jours <= $calendrier_date_mois_nombrejour)
{
	

 ?>
  <tr> 
 
    <?php 
	

 		for ($i = 0 ; $i <= 6 ; $i++)
 		{


			if ($i == date('w', mktime(0,0,0, $calendrier_date_mois, $calendrier_compteur_jours, $calendrier_date_annee)))
			{
				$calendrier_compteur_jours++;		
			}
				
	

			if ($calendrier_compteur_jours.'_'.$calendrier_date_mois.'_'.$calendrier_date_annee == $calendrier_dateDuJour) 
			{
				$class_jour  = 'calendrier_dateDuJour';
			} 
			else 
			{	
				if (in_array($calendrier_compteur_jours.'_'.$calendrier_date_mois.'_'.$calendrier_date_annee, $calendrier_dates_importantes))
				{	
					$class_jour = 'calendrier_date_importante';
				}
				else
				{	
					$class_jour = 'calendrier_date';
				}
			}
?>
    <td class="<?php echo $class_jour ?>"> 
     
	  <?php 
			
				// ---------------AFFICHAGE DES JOURS DU CALENDRIER CORRESPONDANT AU MOIS-----------------
				
			if ($calendrier_compteur_jours != 0 && $calendrier_compteur_jours <= $calendrier_date_mois_nombrejour)	
			{

				// ---------------PERMET DE RAJOUTER UN "0" DEVANT LES DATES A 1 CHIFFRES "1" -> "01"-------------------
				
				if(strlen( $calendrier_compteur_jours)==1)
				{
					$a="0";
					$b=$calendrier_compteur_jours;
					$calendrier_compteur_jours=$a."".$b;	 
				}
				
				switch ($calendrier_mois[$calendrier_date_mois]){
	
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
						$date1=$calendrier_date_annee."-".$mois."-".$calendrier_compteur_jours;
		
				// ---------------SI DATE CHOISIE ALORS CREATION D'UNE SESSION ET CHANGEMENT DU FOND VISUEL SINON AUCUN CHANGEMENT-----------------
					
					
					$base=false;
					$emplacements_reserves = 0;
					
					$datecalend=date_create($date1);
					$td=date_create(date('Y-m-d'));		
					
				
					
					
						
					
					for($j = 0; $j < sizeof($date_debut); $j++)
					{
					
					$madate=date_create($date1);
					$date = date_create($date_debut[$j][0]);
					$date2= date_create($date_fin[$j][0]);	
					
						if((date_timestamp_get($madate) >= date_timestamp_get($date))&&(date_timestamp_get($madate) <= date_timestamp_get($date2)))						
						{
							
							$emplacements_reserves=$emplacements_reserves+$date_debut[$j][1];
						
						}
					}
					// echo date_timestamp_get($madate) - date_timestamp_get($date);
					if($emplacements_reserves+$_SESSION['type']>4){
						$base = true;
					}
				
				if(date_timestamp_get($datecalend)>date_timestamp_get($td))				
				{
				if(!isset($_SESSION['date_debut']))
				{	
					
					if($base==true){
						?><input class="res" name="jour" type="button" value="Rés"><?php
					}
					else	
					{
						?><input name="jour" type="submit" value="<?php echo $calendrier_compteur_jours;?>">
						<input name="mois" type="hidden" value="<?php echo $calendrier_mois[$calendrier_date_mois];?>">
						<input name="annee" type="hidden" value="<?php echo $calendrier_date_annee;?>"><?php	
					}	
				}
				else if (substr(($_SESSION['date_debut']),8,2)==$calendrier_compteur_jours)
				{
			
					?><input  style="background-color:#566573 ; border-color:#566573 " name="jour" type="button" value="<?php echo $calendrier_compteur_jours;?>">
					<?php
				}
				else
				{
					if($base==true){
						?><input  class="res" name="jour" type="button" value="Rés"><?php
					}
					else
					{
					?><input name="jour" type="submit" value="<?php echo $calendrier_compteur_jours;?>">	
					<input name="mois" type="hidden" value="<?php echo $calendrier_mois[$calendrier_date_mois];?>">
					<input name="annee" type="hidden" value="<?php echo $calendrier_date_annee;?>"><?php
					}
				}
				
			}
			else 
			{
			?>
				<input  class="res" name="jour" type="button" value="">
			<?php
			}
			}
			else 
			{
			?>
				<input  class="res" name="jour" type="button" value="">
			<?php
			}
			?>
    </td>
    <?php
	
 		}
		?>
		
		<?php
?>
  </tr>
  <?php 


}

?>
</form>
</table>










<?php

if (!isset($_GET['mois2']) && !isset($_GET['annee2']))
{
	$calendrier_date_mois2 = date('n');
	$calendrier_date_annee2 = date('Y');
}
else
{
	$calendrier_date_mois2 = $_GET['mois2'];
	$calendrier_date_annee2 = $_GET['annee2'];
}

/* Ici on calcul le passage à l'année précédente. */
if ($calendrier_date_mois2 == '1')
{
	$calendrier_date_mois_precedent2 = '12';
	$calendrier_date_annee_precedente2 = $calendrier_date_annee2 - 1;
}
else 
{
	$calendrier_date_mois_precedent2 = $calendrier_date_mois2 - 1;
	$calendrier_date_annee_precedente2 = $calendrier_date_annee2;
}

/* Et ici on calcul le passage à l'année suivante. */
if ($calendrier_date_mois2 == '12')
{
	$calendrier_date_mois_suivant2  = '1';
	$calendrier_date_annee_suivante2  = $calendrier_date_annee2 + 1;
}
else 
{
	$calendrier_date_mois_suivant2  = $calendrier_date_mois2 + 1;
	$calendrier_date_annee_suivante2 = $calendrier_date_annee2;
}


$calendrier_dateDuJour2 = date('j_n_Y'); 



$calendrier_dates_importantes2 = array(	'1_6_2020	', 
										'5_6_2020', 
								       '15_8_2020',
									   '14_7_2020',
									   '20_7_2020',
									    '1_1_2020');

/* le mktime retourne les info d'une date donnée */
$calendrier_mktime2 = mktime(0, 0, 0, $calendrier_date_mois2, 1, $calendrier_date_annee2);



$calendrier_date_mois_1erjour2 = date('w', $calendrier_mktime2);


$calendrier_date_mois_nombrejour2 = date('t', $calendrier_mktime2);



$calendrier_mois2 = array( '1' => 'Janvier',   '2' => 'Février',   '3' => 'Mars', 
						  '4' => 'Avril',     '5' => 'Mai',       '6' => 'Juin',
						  '7' => 'Juillet',   '8' => 'Août',      '9' => 'Septembre',);





if ($calendrier_date_mois2.'_'.$calendrier_date_annee2 == date('n_Y'))
{
	$class_mois2 = 'calendrier_mois_encours';
}
else
{
	$class_mois2 = 'calendrier_mois';
}





if(isset($_SESSION['date_debut']))
{

?>

<table width="200" border="0" align="center" cellpadding="1" cellspacing="1">
 <tr align="center" valign="middle">
  

<?php
if(!isset($_GET['mois']))
{
?>
    <td><?php echo '<a href="?mois2=' , $calendrier_date_mois_precedent2 , '&annee2=' , $calendrier_date_annee_precedente2 , '" class="calendrier_mois"><img src="../img/flechegauche.png" width="60%"></a>'?></td>
	<td colspan="5" class="<?php echo $class_mois2 ?>"><?php echo $calendrier_mois2[$calendrier_date_mois2],' ',$calendrier_date_annee2 ?></td>
    <td><?php echo '<a href="?mois2=' , $calendrier_date_mois_suivant2 , '&annee2=' , $calendrier_date_annee_suivante2 , '" class="calendrier_mois"><img src="../img/flechedroite.png" width="60%"></a>'?></td>
<?php

}
else
{
?>
	<td><?php echo '<a href="?mois=' ,$_GET['mois'] , '&annee=' ,$_GET['annee'], '&mois2=' , $calendrier_date_mois_precedent2 , '&annee2=' , $calendrier_date_annee_precedente2 , '" class="calendrier_mois"><img src="../img/flechegauche.png" width="60%"></a>'?></td>
	<td colspan="5" class="<?php echo $class_mois2 ?>"><?php echo $calendrier_mois2[$calendrier_date_mois2],' ',$calendrier_date_annee2 ?></td>
	<td><?php echo '<a href="?mois=' ,$_GET['mois'] , '&annee=' ,$_GET['annee'], '&mois2=' , $calendrier_date_mois_suivant2 , '&annee2=' , $calendrier_date_annee_suivante2 , '" class="calendrier_mois"><img src="../img/flechedroite.png" width="60%"></a>'?></td>
<?php
}
?>
  </tr>
  <tr> 
    <td class="calendrier_nom_des_jours">Lun</td>
    <td class="calendrier_nom_des_jours">Mar</td>
    <td class="calendrier_nom_des_jours">Mer</td>
    <td class="calendrier_nom_des_jours">Jeu</td>
    <td class="calendrier_nom_des_jours">Ven</td>
    <td class="calendrier_nom_des_jours">Sam</td>
    <td class="calendrier_nom_des_jours">Dim</td>
  </tr>
  <?php

			
$calendrier_compteur_jours2 = 00;





if(isset($_GET['mois2']))
{
if(isset($_GET['mois']))
{
?>
<form action="reservations.php?mois=<?php echo $_GET['mois'];?>&annee=<?php echo $_GET['annee'];?>&mois2=<?php echo $_GET['mois2'];?>&annee2=<?php echo $_GET['annee2'];?>" method="post">
<?php
}
else
{
?>
<form action="reservations.php?mois2=<?php echo $_GET['mois2'];?>&annee2=<?php echo $_GET['annee2'];?>" method="post">	
<?php
}
}
else
{
?>
<form action="reservations.php" method="post">	
<?php
}


while ($calendrier_compteur_jours2 <= $calendrier_date_mois_nombrejour2)
{
	

 ?>
  <tr> 
 
    <?php 
	

 		for ($i = 0 ; $i <= 6 ; $i++)
 		{


			if ($i == date('w', mktime(0,0,0, $calendrier_date_mois2, $calendrier_compteur_jours2, $calendrier_date_annee2)))
			{
				$calendrier_compteur_jours2++;		
			}
				
	

			if ($calendrier_compteur_jours2.'_'.$calendrier_date_mois2.'_'.$calendrier_date_annee2 == $calendrier_dateDuJour2) 
			{
				$class_jour2  = 'calendrier_dateDuJour';
			} 
			else 
			{	
				if (in_array($calendrier_compteur_jours2.'_'.$calendrier_date_mois2.'_'.$calendrier_date_annee2, $calendrier_dates_importantes2))
				{	
					$class_jour2 = 'calendrier_date_importante';
				}
				else
				{	
					$class_jour2 = 'calendrier_date';
				}
			}
?>
    <td class="<?php echo $class_jour2 ?>"> 
     
	  <?php 
			
				// ---------------AFFICHAGE DES JOURS DU CALENDRIER CORRESPONDANT AU MOIS-----------------
				
			if ($calendrier_compteur_jours2 != 0 && $calendrier_compteur_jours2 <= $calendrier_date_mois_nombrejour2)	
			{

				// ---------------PERMET DE RAJOUTER UN "0" DEVANT LES DATES A 1 CHIFFRES "1" -> "01"-------------------
				
				if(strlen( $calendrier_compteur_jours2)==1)
				{
					$a="0";
					$b=$calendrier_compteur_jours2;
					$calendrier_compteur_jours2=$a."".$b;	 
				}
				
				switch ($calendrier_mois2[$calendrier_date_mois2]){
	
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
						$date1=$calendrier_date_annee2."-".$mois."-".$calendrier_compteur_jours2;
		
				// ---------------SI DATE CHOISIE ALORS CREATION D'UNE SESSION ET CHANGEMENT DU FOND VISUEL SINON AUCUN CHANGEMENT-----------------
				
				$base=false;
				$emplacements_reserves = 0;
					
				
					for($j = 0; $j < sizeof($date_debut); $j++)
					{
					
					$madate=date_create($date1);
					$date = date_create($date_debut[$j][0]);
					$date2= date_create($date_fin[$j][0]);	
					
						if((date_timestamp_get($madate) >= date_timestamp_get($date))&&(date_timestamp_get($madate) <= date_timestamp_get($date2)))						
						{
							
							$emplacements_reserves=$emplacements_reserves+$date_debut[$j][1];
						
						}
					}
					
					
					
					if($emplacements_reserves+$_SESSION['type']>4){
						
						$base=true;
					}
					
					
		
				if($_SESSION['date_debut']< $date1)
				{
				if(!isset($_SESSION['date_fin']))
				{	
					if($base==true){
						?><input  class="res" name="jour" type="button" value="Rés"><?php
					}
					else
					{
						?><input name="jour2" type="submit" value="<?php echo $calendrier_compteur_jours2;?>">
						<input name="mois" type="hidden" value="<?php echo $calendrier_mois2[$calendrier_date_mois2];?>">
						<input name="annee" type="hidden" value="<?php echo $calendrier_date_annee2;?>"><?php	
					}
				
				}
				else if (substr(($_SESSION['date_fin']),8,2)==$calendrier_compteur_jours2)
				{
					
					?><input  style="background-color:#566573 ; border-color:#566573 ;" name="jour2" type="button" value="<?php echo $calendrier_compteur_jours2;?>">
					<?php
				}
				else
				{
					if($base==true){
					?><input  class="res" name="jour" type="button" value="Rés"><?php
					}
					else
					{
					
					?><input name="jour2" type="submit" value="<?php echo $calendrier_compteur_jours2;?>" >	
					<input name="mois" type="hidden" value="<?php echo $calendrier_mois2[$calendrier_date_mois2];?>">
					<input name="annee" type="hidden" value="<?php echo $calendrier_date_annee2;?>"><?php
					}
				}
				
				}
				else
				{
					?><input name="jour" type="button" value=""><?php	
				}
			}
			else 
			{
				?><input name="jour" type="button" value=""><?php
			}
			?>
    </td>
    <?php
	
 		}
		?>
		
		<?php
?>
  </tr>
  <?php 


}

?>
</form>
</table>

<?php 
}

}
else
{
}
?>