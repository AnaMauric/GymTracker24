<?php

$DEBUG = true;	 						
include("orodja.php"); 					
$zbirka = dbConnect();		
$datum = date("Y-m-d"); // Outputs the current date in the format: 2024-12-26


 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

 
switch($_SERVER["REQUEST_METHOD"])		
{
	case 'GET':
		if(!empty($_GET["username"]))
		{
			user_exercise($_GET["username"]);		
		}
		else
		{
			http_response_code(400);				
		}
		break;
 

	case 'POST':
		//if(!empty($_GET["userVzdevek"]))
		//{
			dodaj_ali_posodobi_exercise();		
		//}
		//else
		//{
		//	http_response_code(400);				
		//}
		break;


	case 'DELETE':
		//if(!empty($_GET["userVzdevek"]))
		//{
			izbrisi_exercise();		
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


function user_exercise($userVzdevek)
{
	global $zbirka;
	$odgovor=array();

    if (user_obstaja($userVzdevek))
    {
        $poizvedba="SELECT exercise_name, date, weight, sets, reps FROM exercise WHERE username='$userVzdevek' ORDER BY date";

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



function dodaj_ali_posodobi_exercise()
{
    global $zbirka, $DEBUG, $datum;
    
    // Preverimo, ali je telo zahteve ustrezno
    $podatki = json_decode(file_get_contents('php://input'), true);

    if (isset($podatki["username"], $podatki["exercise_name"], $podatki["weight"], $podatki["sets"], $podatki["reps"]))
    {
        
        $userVzdevek = mysqli_escape_string($zbirka, $podatki["username"]);
        $exercise_name = mysqli_escape_string($zbirka, $podatki["exercise_name"]);
        $weight = mysqli_escape_string($zbirka, $podatki["weight"]);
        $sets = mysqli_escape_string($zbirka, $podatki["sets"]);
        $reps = mysqli_escape_string($zbirka, $podatki["reps"]);
        
        // Preveri, ali uporabnik obstaja
        if (user_obstaja($userVzdevek))
        {
            // Preveri, ali obstaja zapis za tega uporabnika, datum in ime vaje
            $preveriPoizvedba = "SELECT 1 FROM exercise 
                                 WHERE username = '$userVzdevek' 
                                 AND exercise_name = '$exercise_name' 
                                 AND date = '$datum' 
                                 LIMIT 1";
            $rezultat = mysqli_query($zbirka, $preveriPoizvedba);

            if (mysqli_num_rows($rezultat) > 0)
            {
                // Posodobi zapis, ker obstaja
                $posodobiPoizvedba = "UPDATE exercise 
                                      SET weight = '$weight', sets = '$sets', reps = '$reps' 
                                      WHERE username = '$userVzdevek' 
                                      AND exercise_name = '$exercise_name' 
                                      AND date = '$datum'";
                
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
                $dodajPoizvedba = "INSERT INTO exercise (username, exercise_name, date, weight, sets, reps) 
                                   VALUES ('$userVzdevek', '$exercise_name', '$datum', '$weight', '$sets', '$reps')";

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


function izbrisi_exercise()
{
    global $zbirka, $DEBUG;

    // Preberi podatke iz telesa zahteve
    $podatki = json_decode(file_get_contents('php://input'), true);

    if (isset($podatki["username"], $podatki["exercise_name"], $podatki["date"]))
    {
        // Preveri, ali uporabnik obstaja
        if (user_obstaja($podatki["username"]))
        {
            $userVzdevek = mysqli_escape_string($zbirka, $podatki["username"]);
            $exercise_name = mysqli_escape_string($zbirka, $podatki["exercise_name"]);
            $date = mysqli_escape_string($zbirka, $podatki["date"]);

            // Poizvedba za brisanje vnosa
            $brisanjePoizvedba = "DELETE FROM exercise 
                                  WHERE username = '$userVzdevek' 
                                  AND exercise_name = '$exercise_name' 
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