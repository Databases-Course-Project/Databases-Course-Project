<?php

	$link = mysqli_connect("127.0.0.1", "root", "mypassword", "museo");

	if (!$link) { // if ($link == NULL)
		echo "Si è verificato un errore: impossibile collegarsi al database <br/>";
		echo "Codice errore: " . mysqli_connect_errno() . "<br/>";
		echo "Messaggio errore: " . mysqli_connect_error() . "<br/>";
		exit;
	}

	$name           = $_POST['name'];
	$gender         = $_POST['gender'];
	$year_of_birth  = $_POST['year_of_birth'];
	$year_of_death  = $_POST['year_of_death'];
	$place_of_birth = $_POST['place_of_birth'];
    $place_of_death = $_POST['place_of_death'];
	
	$sql = "SELECT *
            FROM Artists
            WHERE (name LIKE '%$name%' AND gender LIKE '%$gender%' AND year_of_birth LIKE '%$year_of_birth%' AND year_of_death LIKE '%$year_of_death%' AND place_of_birth LIKE '%$place_of_birth%' AND place_of_death LIKE '%$place_of_death%')";
	
	$query = mysqli_query($link, $sql);

	if (!$query) {
		echo "Si è verificato un errore: " . mysqli_error($link);
		exit;
	}
?>

<html lang="it">    
    <head>
        <meta charset="utf-8">
		        
		<title>Esempio HTML + PHP</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}
		</style>
    </head>
    <body>
        <h1>Ricerca Artisti</h1>

		<form action="get.php" method="POST">
			<fieldset>
				<label>Nome:</label>
				<input type="text" name="name" value="<?php echo htmlspecialchars($name);?>" autofocus >
			</fieldset>
			<fieldset>
				<label>Sesso:</label>
                
				<select name="gender">
                    <option value="" <?php echo htmlspecialchars(($gender == "") ? "selected" : "");?>>Non Selezionato</option> 
					<option value="M" <?php echo htmlspecialchars(($gender == "M") ? "selected" : "");?>>Maschio</option>	
					<option value="F" <?php echo htmlspecialchars(($gender == "F") ? "selected" : "");?>>Femmina</option>	
				</select>
			</fieldset>
			<fieldset>
				<label>Anno di nascita:</label>
				<input type="text" name="year_of_birth" value="<?php echo htmlspecialchars($year_of_birth);?>" >
			</fieldset>
			<fieldset>
				<label>Anno di morte:</label>
				<input type="text" name="year_of_death" value="<?php echo htmlspecialchars($year_of_death);?>">
			</fieldset>
			<fieldset>
				<label>Paese di nascita:</label>
				<input type="text" name="place_of_birth" value="<?php echo htmlspecialchars($place_of_birth);?>">
			</fieldset>
			<fieldset>
				<label>Paese di morte:</label>
				<input type="text" name="place_of_death" value="<?php echo htmlspecialchars($place_of_death);?>">
			</fieldset>

			<input type="submit" value="search" />
		</form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Sesso</th>
                    <th>Anno di Nascita</th>
                    <th>Anno di Morte</th>
                    <th>Paese di Nascita</th>
                    <th>Paese di Morte</th>
                    <th>URL</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['year_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars($row['year_of_death']); ?></td>
                    <td><?php echo htmlspecialchars($row['place_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars($row['place_of_death']); ?></td>
                    <td><?php echo htmlspecialchars($row['url']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php mysqli_close($link); ?>
    </body>
</html>