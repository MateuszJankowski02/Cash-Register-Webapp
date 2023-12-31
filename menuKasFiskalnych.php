<?php
 session_start();
 error_reporting(E_ERROR | E_PARSE); //wyłączenie pokazywanie błędów

 if((!isset($_SESSION['zalogowany'])) || ($_SESSION['zalogowany']!=true))
	{
		header('Location: index.php');
		exit();
	}

function zadanie_admin()
{
    $plik=fopen("zadanie.txt","w"); //zmienna z plikiem, tylko zapis
    echo<<<END
        <div class="position-middle-row1" id="dodaj-zadanie">
        <form method="POST">
            <h2>ZADANIE</h2> 
            <input class="dane-input" type="text" name="zadanko">
            <div class='button-dodaj'><input class="button" type="submit" value="Wyślij"></div>
        </form>
        </div>
    END;
    $zadanko=$_POST['zadanko'];
    fwrite($plik, $zadanko);
    fclose($plik);
}
function zadanie_uzyt()
{
    $plik=fopen("zadanie.txt","r"); //zmienna z otwartym plikiem, tylko odczyt

    if(file_get_contents("zadanie.txt")) //jeśli plik nie jest pusty
    {
        echo '<center><h2>Zadanie do wykonania:</h2><br />'.fgets($plik, $zadanko).'<br /><form method="POST"><input type="submit" value="Wykonano" name="przycisk"/>'.'</form>'.'</center>'; //wyświetlanie zadania jeśli coś jest w pliku
        if(isset($_POST['przycisk']))
        {
            $plik=fopen("zadanie.txt","w"); //zmienna z plikiem, tylko zapis

            file_put_contents("zadanie.txt", "");
            if(!file_get_contents("zadanie.txt")) header("Location: menuKasFiskalnych.php");
        }

        //if($polecenie=="Wykonano") /ftruncate("zadanie.txt", 1);
    }
    else if(!file_get_contents("zadanie.txt")) echo "<center>Brak zadań</center>"; //jeśli plik jest pusty
    fclose($plik); //zamykanie pliku
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/e7af9736bb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/style-menu.css">
    <link rel="stylesheet" href="CSS/style-strona.css">
    <title>Menu Kas Fiskalnych</title>
    <script src="Javascript/user-details.js" defer></script>
</head>
<body class="menu-preload">
    <div id='main'>
        <div id="heading-user">
            <div id="heading">
                <h1>System Zarządzania Kasami Fiskalnymi</h1>
            </div>
            <div id='logged-user'>
                <span id="logged-user-icon"><i class="fas fa-user" onClick="managePopupWindow()"></i></span><?php echo "<p>".$_SESSION['imie']."</p>";?>
            </div>
        </div>
        <div class="content">
            <?php
                if($_SESSION['admin']==1)
                {
                    zadanie_admin();
                }
                else if($_SESSION['admin']!=1)
                {
                    zadanie_uzyt();
                }
            ?>
        </div>
        <!-- Znikające okna początek -->
        <div id="user-details-window">
            <?php echo "<p>".$_SESSION['imie']." ".$_SESSION['nazwisko']."</p><p>@".$_SESSION['login']."</p>"; ?>
            <a href='logout.php'>Wyloguj</a>
        </div>
        <div>
            <input type="checkbox" id="menu-checkbox" onClick="checkState()">
            <label for="menu-checkbox" id="menu-checkbox2">
                <i class="fas fa-bars"></i>
            </label>
            <!-- Javascript - menu.js -->
            <script src="JavaScript/menu.js"></script>
            <!-- Javascript - menu.js -->  
            <div class='sidebar sidebar-position'>
                <div class='sidebar-header'>Menu</div>
                <ul class='sidebar-content-underline'>
                    <li><a href='menuKasFiskalnych.php'><i class="fas fa-bookmark"></i>Menu Główne</a></li>
                    <li><a href='przeglady.php'><i class="fas fa-cash-register"></i>Przeglądy</a></li>
                    <li><a href='listaKasFiskalnych.php'><i class="fas fa-list"></i>Lista kas fiskalnych</a></li>
                    <li><a href='dodawanieKasFiskalnych.php'><i class="fas fa-plus"></i>Dodaj kasę fisklaną</a></li>
                    <li><a href='dodawaniePrzegladow.php'><i class="far fa-calendar-plus"></i></i>Dodaj przegląd</a></li>
                    <li><a href='klienci.php'><i class="fas fa-id-card"></i>Klienci</a></li>
                    <li><a href='wyslijMaila.php'><i class="far fa-envelope"></i>Wyślij maila do klienta</a></li>
                    <?php 
                    if($_SESSION['admin']==1){
                        echo "<li><a href='uzytkownicy.php'><i class='fas fa-address-book'></i>Użytkownicy</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
