<?php

$DEBUG = true;							
include("orodja.php"); 					
$zbirka = dbConnect();

header('Content-Type: application/json');	
header('Access-Control-Allow-Origin: *');  // Omogoči vse domene
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');  // Dovoljene metode
header('Access-Control-Allow-Headers: Content-Type');  // Dovoljeni naslovi

 
switch($_SERVER["REQUEST_METHOD"])		
{
	case 'GET':
		if(!empty($_GET["userVzdevek"]))
		{
			pridobi_user($_GET["userVzdevek"]);		
		}
		else
		{
			//pridobi_vse_user();	
			http_response_code(400);				
		}
		break;
 


	case 'POST':
		dodaj_user();
		//http_response_code(404);
		break;
 


	case 'PUT':
		//if(!empty($_GET["userVzdevek"]))
		//{
		posodobi_user();
		//}
		//else
		//{
		//	http_response_code(400);
		//}
		break;



	case 'DELETE':
		//if(!empty($_GET["userVzdevek"]))
		//{
		izbrisi_user();
		//}
		//else
		//{
		//	http_response_code(400);
		//}
		break;

 
	default:
		http_response_code(405);		
		break;
}
 
mysqli_close($zbirka);					
 
 

 
/*function pridobi_vse_user()
{
	global $zbirka;
	$odgovor=array();
 
	$poizvedba="SELECT username, birthday, weight FROM user";	
 
	$rezultat=mysqli_query($zbirka, $poizvedba);
 
	while($vrstica=mysqli_fetch_assoc($rezultat))
	{
		$odgovor[]=$vrstica;
	}
 
	http_response_code(200);		
	echo json_encode($odgovor);
}*/



function pridobi_user($userVzdevek)
{
	/*global $zbirka;
	$userVzdevek=mysqli_escape_string($zbirka, $userVzdevek);
 
	$poizvedba="SELECT username, birthday, weight FROM user WHERE username='$userVzdevek'";
 
	$rezultat=mysqli_query($zbirka, $poizvedba);
 
	if(mysqli_num_rows($rezultat)>0)	
	{
		$odgovor=mysqli_fetch_assoc($rezultat);
 
		http_response_code(204);		
		echo json_encode($odgovor);
	}
	else							
	{
		http_response_code(404);		
	}*/


	global $zbirka;
	$odgovor=array();

    if (user_obstaja($userVzdevek))
    {
        $poizvedba="SELECT birthday, weight FROM user WHERE username='$userVzdevek'";

            $result=mysqli_query($zbirka, $poizvedba);

            while($vrstica=mysqli_fetch_assoc($result))
		    {
			    $odgovor=$vrstica;
		    }

            http_response_code(200);		
		    echo json_encode($odgovor);

    }
	
    else
	{
		http_response_code(404);	
	}  


}
 


function dodaj_user()
{
	global $zbirka, $DEBUG;
	$podatki = json_decode(file_get_contents("php://input"),true);

	if (isset($podatki["username"], $podatki["password"]))
	{
		$userVzdevek = mysqli_escape_string($zbirka, $podatki["username"]);
		$userPassword = mysqli_escape_string($zbirka, $podatki["password"]);
		
		if(!user_obstaja($userVzdevek))
		{	
			$poizvedba = "INSERT INTO user (username, password) VALUES ('$userVzdevek', '$userPassword')";
 
			if(mysqli_query($zbirka, $poizvedba))
			{
				http_response_code(201);
				$odgovor = URL_vira($userVzdevek);
				echo json_encode($odgovor);
			}
			else
			{
				http_response_code(500);
				if($DEBUG)
				{
					pripravi_odgovor_napaka(mysqli_error($zbirka));
				}
			}
		}
		else
		{
			/*$userVzdevek = mysqli_escape_string($zbirka, $podatki["username"]);
			$userPassword = mysqli_escape_string($zbirka, $podatki["password"]);
			$poizvedba = "SELECT password FROM user WHERE username = '$userVzdevek'";

			if(strcmp($userPassword, $poizvedba) == 0){
				http_response_code(200);
			} else {
				http_response_code(405);
			}
			*/

			http_response_code(200);
	
		}
	}

	elseif(isset($podatki["username"], $podatki["password"], $podatki["birthday"], $podatki["weight"]))
	{
		$userVzdevek = mysqli_escape_string($zbirka, $podatki["username"]);
		$userPassword = mysqli_escape_string($zbirka, $podatki["password"]);
		$birthday = mysqli_escape_string($zbirka, $podatki["birthday"]);
		$weight = mysqli_escape_string($zbirka, $podatki["weight"]);
 
		if(user_obstaja($userVzdevek))
		{	
			$poizvedba = "UPDATE user (password, birthday, weight) VALUES ('$userPassword', '$birthday', '$weight') WHERE username='$userVzdevek'";
 
			if(mysqli_query($zbirka, $poizvedba))
			{
				http_response_code(201);
			}
			else
			{
				http_response_code(500);
				if($DEBUG)
				{
					pripravi_odgovor_napaka(mysqli_error($zbirka));
				}
			}
		}
		else
		{
			http_response_code(409);
		}
	}
	else
	{
		http_response_code(response_code: 405);
	}
}
 



function posodobi_user()
{
	global $zbirka, $DEBUG;
	$podatki = json_decode(file_get_contents("php://input"),true);

	if (isset($podatki["username"], $podatki["password"], $podatki["birthday"], $podatki["weight"]))
	{
		$userVzdevek = mysqli_escape_string($zbirka, $podatki["username"]);
		$userPassword = mysqli_escape_string($zbirka, $podatki["password"]);
		$birthday = mysqli_escape_string($zbirka, $podatki["birthday"]);
		$weight = mysqli_escape_string($zbirka, $podatki["weight"]);	

		if(user_obstaja($userVzdevek)){
			$poizvedba = "UPDATE user SET password = '$userPassword', birthday = '$birthday', weight = '$weight' WHERE username = '$userVzdevek'";
			
			if(mysqli_query($zbirka, $poizvedba))
			{
				http_response_code(204);	
			} else {
				http_response_code(500);
				if($DEBUG)
				{
					pripravi_odgovor_napaka(mysqli_error($zbirka));
				}
			}
	
		}else {
			http_response_code(404);	
		}
	} else {
		http_response_code(400);	
	}
 
	/*if(user_obstaja($userVzdevek))
	{
		if($podatki["weight"])
		{
			$weight = mysqli_escape_string($zbirka, $podatki["weight"]);
 
			$poizvedba = "UPDATE user SET weight=$weight WHERE username='$userVzdevek'";
 
			if(mysqli_query($zbirka, $poizvedba))
			{
				http_response_code(204);	
			}
			else
			{
				http_response_code(500);
				if($DEBUG)
				{
					pripravi_odgovor_napaka(mysqli_error($zbirka));
				}
			}
		}
		else
		{
			http_response_code(400);	
		}
	}
	else
	{
		http_response_code(404);	
	}*/
}



function izbrisi_user()
{
	global $zbirka, $DEBUG;
	$podatki = json_decode(file_get_contents("php://input"),true);

	if (isset($podatki["username"]))
	{
		$userVzdevek = mysqli_escape_string($zbirka, $podatki["username"]);

		if(user_obstaja($userVzdevek))
		{
			$poizvedba = "DELETE FROM user WHERE username='$userVzdevek'";
			if(mysqli_query($zbirka, $poizvedba))
			{
				http_response_code(204);
			}
			else
			{
				http_response_code(500);
				if($DEBUG)
				{
					pripravi_odgovor_napaka(mysqli_error($zbirka));
				}
			}
		}
		else
		{
			http_response_code(404);	
		}
		
		}
}




 
?>