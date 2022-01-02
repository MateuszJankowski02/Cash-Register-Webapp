<?php
	session_start();
	//WALIDACJA DANYCH Z FOMRULARZA
	if((!isset($_SESSION['zalogowany'])) || ($_SESSION['zalogowany']!=true) || $_SESSION['admin']!=1)
	{
		header('Location: index.php');
		exit();
	}

	if(isset($_POST['imie']))
	{
		$ok=true; //flaga poprawności

		//SPRAWDZANIE IMIENIA
		$imie=$_POST['imie'];
		if(strlen($imie)>20 || ctype_alnum($imie)==false) //imie ma wiecej niz 20 lub ma inne znaki
		{
			$_SESSION['bladi'] = "BŁĄD PRZY WPISYWANIU IMIENIA!";
			$ok=false; //niepoprawność danych
		}
		else
		{
			if(isset($_SESSION['bladi'])) unset($_SESSION['bladi']);
			$imie[0]=strtoupper($imie[0]); //zamiana pierwszej litery imienia na jej większy odpowiednik
		}

		//SPRAWDZANIE NAZWISKA
		$nazwisko=$_POST['nazwisko'];
		if(strlen($nazwisko)>28 || ctype_alnum($nazwisko)==false) //imie ma wiecej niz 28 lub ma inne znaki
		{
			$_SESSION['bladn'] = "BŁĄD PRZY WPISYWANIU NAZWISKA!";
			$ok=false; //niepoprawność danych
		}
		else
		{
			if(isset($_SESSION['bladn'])) unset($_SESSION['bladn']);
			$nazwisko[0]=strtoupper($nazwisko[0]); //zamiana pierwszej litery imienia na jej większy odpowiednik
		}

		//SPRAWDZANIE EMAILA
		$email=$_POST['email'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['blade']="BŁĄD PRZY WPISYWANIU EMAILA!";
			$ok=false;
		}
		else
		{
			if(isset($_SESSION['blade'])) unset($_SESSION['blade']);
		}
		//SPRAWDZANIE LOGINU
		$login=$_POST['login'];
		if(strlen($login)<8 || ctype_alnum($login)==false)
		{
			$_SESSION['bladl']="BŁĄD PRZY WPISYWANIU LOGINU!";
			$ok=false;
		}
		else
		{
			if(isset($_SESSION['bladl'])) unset($_SESSION['bladl']);
		}
		//SPRAWDZANIE HASŁA
		$haslo=$_POST['haslo'];
		if(strlen($haslo)<8 || ctype_alnum($haslo)==false)
		{
			$_SESSION['bladh']="BŁĄD PRZY WPISYWANIU HASŁA!";
			$ok=false;
		}
		else
		{
			if(isset($_SESSION['bladh'])) unset($_SESSION['bladh']);
		}
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Dodawanie nowego użytkownika</title>
	<meta charset="UTF-8" />
</head>
<body>
	<form method="POST">
		Imie: <input type="text" name="imie"/><?php if(isset($_SESSION['bladi'])) echo$_SESSION['bladi'];  ?>(może składać się z maks 20 polskich znaków)<br />
		Nazwisko: <input type="text" name="nazwisko"/><?php if(isset($_SESSION['bladn'])) echo$_SESSION['bladn'];  ?> (może składać się z maks 28 polskich znaków)<br />
		Email: <input type="text" name="email"/><?php if(isset($_SESSION['blade'])) echo$_SESSION['blade'];  ?><br />
		Login: <input type="text" name="login"/><?php if(isset($_SESSION['bladl'])) echo$_SESSION['bladl'];  ?> (minimum 8 liter)<br />
		Hasło: <input type="text" name="haslo"/><?php if(isset($_SESSION['bladh'])) echo$_SESSION['bladh'];  ?>(minimum 8 liter)<br />
		<input type="submit" value="Dodaj" />
	</form>
</body>
</html>