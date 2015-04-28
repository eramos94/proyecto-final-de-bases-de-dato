<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<style type="text/css">
    .table-scroll{
    	margin: 20px;
    }
</style>
<body>
<?php
require_once("checklogin.php");


// Displays voluntary employees in table and allows for it to delete and add data.
$server = "localhost";
$dB = "avalles";
$user = "avalles";
$password = "avalles@";
$coneccion = new mysqli($server, $user, $password, $dB);
if ($coneccion->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>

  <div class="container">

      <form class="form-signin" method="post" enctype="application/x-www-form-urlencoded">
        <h3 class="form-signin-heading">Llene todos los espacios para añadir voluntarios: </h3>
        <label for="nombre_vol" class="sr-only">Nombre del Voluntario</label>
        <input type="text" name = "nombre_vol" id="nombre_vol" class="form-control" placeholder="Nombre del Voluntario" required autofocus>
        </br>
        <label for="email" class="sr-only">Email</label>
        <input type="text" name = "email" id="email" class="form-control" placeholder="Email" required>
        </br>
        <label for="direccion_vol" class="sr-only">Direccion Postal</label>
        <input type="text" name = "direccion_vol" id="direccion_vol" class="form-control" placeholder="Dirección Postal" required autofocus>
        </br>
        <label for="telefono_vol" class="sr-only">Telefono</label>
        <input type="text" name = "telefono_vol" id="telefono_vol" class="form-control" placeholder="Teléfono" required>
        </br>
        <label for="sexo_vol" class="sr-only">Sexo</label>
        <input type="text" name = "sexo_vol" id="sexo_vol" class="form-control" placeholder="Sexo" required>
        </br>
        </div>
        <center>
        <button type="submit" id ="submit" name = "submit" class="btn btn-lg btn-primary btn-danger">Editar</button>
        </center>
      </form>

    </div> <!-- /container -->

<?php

if (isset($_POST["submit"])) {
	$nombre_vol = $_POST["nombre_vol"];
	$email = $_POST["email"];
	$direccion_vol = $_POST["direccion_vol"];
	$telefono_vol = $_POST["telefono_vol"];
	$sexo_vol = $_POST["sexo_vol"];
	mysqli_query($coneccion,"INSERT INTO voluntario ('nombre_vol', 'email', 'direccion_vol', 'telefono_vol', 'sexo_vol',
		VALUES ($nombre_vol, $email, $direccion_vol, $telefono_vol, $sexo_vol)");
}

print "</br>";
print "<font size = '5'> Lista de Voluntarios: </font>";
print "<br/>";
print "<font size = '3'> Seleccione la información que desea borrar. </font>";
print "<br/>";

print "<div class = 'table-scroll'>";
    print "<div class = 'table-responsive'>"; 
        print "<table class='table table-bordered'>";
		$query = "SELECT * FROM voluntario";

		if ($stmt = $coneccion->prepare($query) ) {
		$stmt -> execute();
		$stmt -> bind_result($id_vol, $nombre_vol, $email, $direccion, $telefono, $sexo_vol);

		$columnas = array("#", "ID del Voluntario", "Nombre del Voluntario", "Email", "Direccion", "Telefono", "Sexo");
		print "<thead>";
		for ($i = 0; $i < 7; $i++) {
			print"<th>";
			print $columnas[$i];
			print"</th>";
		}
		print "</thead>";
		print "<tbody>";
		while( $stmt -> fetch() ) {
			print"<tr>";
			printf(" <td align='center' bgcolor= '#FFFFFF'> <input name='checkbox[]' type='checkbox' id='checkbox[]' value='$id_vol'> </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> \n", 
			 	 $id_vol, $nombre_vol, $email, $direccion, $telefono, $sexo_vol);
			print"</tr>";
		}
		print "</tbody>";
		print "</table>";

		print "<align='center' bgcolor='#FFFFFF'> <input type='submit' id='delete' name = 'delete' value='Borrar'>";
		
		$result = 0;
		// Check if delete button active, start this 
		if (isset($_POST['delete'])) {
			for ($i = 0; $i < 2 ; $i++){
				$del_id = $checkbox[$i];
				mysqli_query($coneccion, "DELETE FROM voluntario WHERE id_vol = '$del_id'");

				}
			}
			// if successful redirect to delete_multiple.php 
		if ($result) {
			echo "<meta http-equiv=\'refresh\' content=\'0;URL=editvoluntarios.php\'>";
		}
		$stmt->close();
		}

    print "</div>";
print "</div>";

$coneccion ->close();
?>
<h3><a href="menuprincipal.php">Menu Principal</a></h3>
</body>
</html>