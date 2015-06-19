<?php
	if (!empty($_POST))
		{
			if (empty($_POST['f']['username']) || empty($_POST['f']['password'])
			)
				{
					$message['error'] = 'Es wurden nicht alle Felder ausgefüllt.';
				}
			else
				{
					$mysqli = @new mysqli('localhost', 'root', '', 'quasifertig');
					if ($mysqli->connect_error)
						{
							$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
						}
					$query = sprintf ("SELECT UserId, username, password FROM users WHERE username = '%s'", $mysqli->real_escape_string ($_POST['f']['username']));
					$result = $mysqli->query ($query);
					$row = $result->fetch_array (MYSQLI_ASSOC);

					if (password_verify ($_POST['f']['password'], $row['password']))
						{
							echo 'Password is valid!';
						}
					else
						{
							echo 'Invalid password.';
						}
					if ($row)
						{
							if (password_verify ($_POST['f']['password'], $row['password']))
								{
									print_r ("GEHT");

									session_start ();

									$_SESSION = array ('login' => TRUE, 'user' => array ('username' => $row['username'],'UserId' => $row['UserId'] ));
									$message['success'] = 'Anmeldung erfolgreich, <a href="joblist.php">weiter zum Inhalt.';
									header ('Location: http://' . $_SERVER['HTTP_HOST'] . '/hprelaunch/index.php');
								}
							else
								{
									$message['error'] = 'Das Kennwort ist nicht kordfdfdfrekt.';
								}
						}
					else
						{
							$message['error'] = 'Der Benutzer wurde nicht gefunden.';
						}
					$mysqli->close ();
				}
		}
	else
		{
			$message['notice'] = 'Geben Sie Ihre Zugangsdaten ein um sich anzumelden.<br />' . 'Wenn Sie noch kein Konto haben, gehen Sie <a href="./register/register.php">zur Registrierung</a>.';
		}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>

	<!-- Bootstrap JS -->

    <script language="javascript" type="text/javascript" src="../js/bootstrap.js"></script>
    <link rel = "stylesheet" href = "./css/bootstrap.css"> 
    <link rel = "stylesheet" href = "./css/customlogin.css"> 
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Einloggen um fortzufahren</h1>
            <div class="account-wall">
                <img class="profile-img" src="./images/logo.png"
                    alt="">
                <form class="form-signin" action="./login.php" method="post">
                <?php if (isset($message['error'])): ?>
					<fieldset class = "error">
					<legend>Fehler</legend><?php echo $message['error'] ?></fieldset>
            	<?php endif ?>
            
                <input type="text" name="f[username]"  class="form-control" placeholder="Email" required autofocus>
                
                <input type="password" name="f[password]" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Anmelden</button>
                <label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Remember me
                </label>
                <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                </form>
            </div>
            <a href="../../Homepage/register/register.php" class="text-center new-account">Neu auf dieser Seite? Hier registrieren </a>
        </div>
    </div>
</div>

</body>
</html>