<?php 

$DEBUG = true;	 						
include("orodja.php"); 					
$zbirka = dbConnect();					
 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

switch($_SERVER["REQUEST_METHOD"])		
{
	case 'GET':
		if(!empty($_GET["userVzdevek"]))
		{
			user_nutrition($_GET["userVzdevek"]);		
		}
		else
		{
			http_response_code(400);				
		}
		break;
 

	case 'POST':
		if(!empty($_GET["userVzdevek"]))
		{
			dodaj_ali_posodobi_nutrition($_GET["userVzdevek"]);		
		}
		else
		{
			http_response_code(400);				
		}
		break;


	case 'DELETE':
		if(!empty($_GET["userVzdevek"]))
		{
			izbrisi_nutrition($_GET["userVzdevek"]);		
		}
		else
		{
			http_response_code(400);				
		}
		break;
 
	default:
		http_response_code(405);		
		break;
}
 
mysqli_close($zbirka);	



function user_nutrition($userVzdevek)
{
	global $zbirka;
	$userVzdevek=mysqli_escape_string($zbirka, $userVzdevek);
	$odgovor=array();
	
	if(user_obstaja($userVzdevek))
	{
		$poizvedba="SELECT date, calories, protein, carbs, fat, sleep_hours FROM nutrition WHERE username='$userVzdevek'";
		
		$result=mysqli_query($zbirka, $poizvedba);

		while($vrstica=mysqli_fetch_assoc($result))
		{
			$odgovor[]=$vrstica;
		}
		
		http_response_code(200);		
		echo json_encode($odgovor);
	}
	else
	{
		http_response_code(404);	
	}
}



function dodaj_ali_posodobi_nutrition($userVzdevek)
{
    global $zbirka, $DEBUG;
    
    $podatki = json_decode(file_get_contents('php://input'), true);

    if (isset($podatki["date"], $podatki["calories"], $podatki["protein"], $podatki["carbs"], $podatki["fat"], $podatki["sleep_hours"]))
    {
        if (user_obstaja($userVzdevek))
        {
            $userVzdevek = mysqli_escape_string($zbirka, $userVzdevek);
            $date = mysqli_escape_string($zbirka, $podatki["date"]);
            $calories = mysqli_escape_string($zbirka, $podatki["calories"]);
            $protein = mysqli_escape_string($zbirka, $podatki["protein"]);
            $carbs = mysqli_escape_string($zbirka, $podatki["carbs"]);
            $fat = mysqli_escape_string($zbirka, $podatki["fat"]);
            $sleep_hours = mysqli_escape_string($zbirka, $podatki["sleep_hours"]);

            $preveriPoizvedba = "SELECT 1 FROM nutrition 
                                 WHERE username = '$userVzdevek'  
                                 AND date = '$date' 
                                 LIMIT 1";
            $rezultat = mysqli_query($zbirka, $preveriPoizvedba);

            if (mysqli_num_rows($rezultat) > 0)
            {
                $posodobiPoizvedba = "UPDATE nutrition
                                      SET calories = '$calories', protein = '$protein', carbs = '$carbs', fat = $fat, sleep_hours = $sleep_hours 
                                      WHERE username = '$userVzdevek'  
                                      AND date = '$date'";
                
                if (mysqli_query($zbirka, $posodobiPoizvedba))
                {
                    http_response_code(200); // Uspešno posodobljeno
                }
                else
                {
                    http_response_code(500); // Napaka pri posodobitvi
                    if ($DEBUG)
                    {
                        pripravi_odgovor_napaka(mysqli_error($zbirka));
                    }
                }
            }
            else
            {
                // Ustvari nov zapis, ker ne obstaja
                $dodajPoizvedba = "INSERT INTO nutrition (username, date, calories, protein, carbs, fat, sleep_hours) 
                                   VALUES ('$userVzdevek', '$date', '$calories', '$protein', '$carbs', '$fat', '$sleep_hours')";

                if (mysqli_query($zbirka, $dodajPoizvedba))
                {
                    http_response_code(201); // Ustvarjeno
                }
                else
                {
                    http_response_code(500); // Napaka pri vnosu
                    if ($DEBUG)
                    {
                        pripravi_odgovor_napaka(mysqli_error($zbirka));
                    }
                }
            }
        }
        else
        {
            http_response_code(409); // Uporabnik ne obstaja
            pripravi_odgovor_napaka("User ne obstaja!");
        }
    }
    else
    {
        http_response_code(400); // Manjkajo podatki
        pripravi_odgovor_napaka("Manjkajo obvezni podatki v telesu zahteve!");
    }
}


function izbrisi_nutrition($userVzdevek)
{
    global $zbirka, $DEBUG;

    $podatki = json_decode(file_get_contents('php://input'), true);

    if (isset($podatki["date"]))
    {
        if (user_obstaja($userVzdevek))
        {
            $userVzdevek = mysqli_escape_string($zbirka, $userVzdevek);
            $date = mysqli_escape_string($zbirka, $podatki["date"]);

            // Poizvedba za brisanje vnosa
            $brisanjePoizvedba = "DELETE FROM nutrition 
                                  WHERE username = '$userVzdevek' 
                                  AND date = '$date'";
            
            if (mysqli_query($zbirka, $brisanjePoizvedba))
            {
                if (mysqli_affected_rows($zbirka) > 0)
                {
                    http_response_code(200); // Uspešno izbrisano
                }
                else
                {
                    http_response_code(404); // Zapis ni bil najden
                    pripravi_odgovor_napaka("Zapis za podanega uporabnika, ime vaje in datum ni bil najden!");
                }
            }
            else
            {
                http_response_code(500); // Napaka pri brisanju
                if ($DEBUG)
                {
                    pripravi_odgovor_napaka(mysqli_error($zbirka));
                }
            }
        }
        else
        {
            http_response_code(409); // Uporabnik ne obstaja
            pripravi_odgovor_napaka("User ne obstaja!");
        }
    }
    else
    {
        http_response_code(400); // Manjkajo podatki
        pripravi_odgovor_napaka("Manjkajo obvezni podatki v telesu zahteve!");
    }
}


?>