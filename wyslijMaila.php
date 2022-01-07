<?php
 session_start();
 error_reporting(E_ERROR | E_PARSE); //wyłączenie pokazywania błędów

 if((!isset($_SESSION['zalogowany'])) || ($_SESSION['zalogowany']!=true))
	{
		header('Location: index.php');
		exit();
	}
function wysylanie()
{
    $host = "localhost"; //adres hosta
	$name = "root";	//nazwa użytkownika
	$pass = "";	//hasło, jeśli nie ma zostawić puste
	$dbname = "projekt"; //nazwa bazy danych
	$conn = mysqli_connect($host, $name, $pass, $dbname); //połączenie z bazą danych

    if(mysqli_connect_errno()) echo "Usługa tymczasowo niedostępna przez problemy techniczne.";
    else
    {
        $email_zalogowanego=$_SESSION['email'];
        $kwerenda="SELECT email FROM uzytkownicy WHERE email='$email_zalogowanego'";
        if(mysqli_query($conn, $kwerenda))
        {
            echo<<<END
                <form method="POST">
                E-mail: <input type="text" name="email" /><br />
                Tresc: <textarea type="text" name="tresc" rows="10"></textarea><br />
                <input type="submit" value="Wyślij" />
                </form>
            END;
            $email=$_POST['email'];
            $tresc=$_POST['tresc'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) //Jeśli email jest niepoprawny
            {
                $_SESSION['blademail']="<center>Źle wprowadzony e-mail!</center>";
                echo $_SESSION['blademail'];
            }
            if((empty($email))||(empty($tresc))) //jeśli zmienne email i tresc są puste wykonaj
            {
                $_SESSION['bladwypelniania']="<center>Wypełnij dane!</center>";
                echo $_SESSION['bladwypelniania'];
            }
            else //wszystko jest w porządku
            {     
                if(isset($_SESSION['bladwypelniania'])) unset($_SESSION['bladwypelniania']);
                if(isset($_SESSION['blademail'])) unset($_SESSION['blademail']);
                $plik=fopen("mail.txt","w"); //zmienna z plikiem mail.txt, tylko zapis (w)
                fwrite($plik, "Nadawca: $email_zalogowanego\nOdbiorca: $email\nTreść: $tresc");
                fclose($plik);
            }
        mysqli_close($conn);
        }
    }
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
    <title>Wyślij maila</title>
    <script src="Javascript/user-details.js" defer></script>
</head>
<body class="menu-preload">
    <div id='main'>
        <div id="heading-user">
            <div id="heading">
                <h1>Wyślij maila do klienta</h1>
            </div>
            <div id='logged-user'>
                <span id="logged-user-icon"><i class="fas fa-user" onClick="managePopupWindow()"></i></span><?php echo "<p>".$_SESSION['imie']."</p>";?>
            </div>
        </div>
        <div class="content">
            <div id="wyslij-mail">
                <?php
                    wysylanie();
                ?>
            </div>
        </div>
        <!-- Znikające okna początek -->
        <div id="user-details-window">
            <p>Zalogowano jako:</p> <?php echo "<p>".$_SESSION['imie']." ".$_SESSION['nazwisko']."</p><p>@".$_SESSION['login']."</p>"; ?>
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