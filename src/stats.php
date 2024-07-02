<?php
	$link = mysqli_connect("127.0.0.1", "root", "mypassword", "museo");

    # number of artworks created in a specific year
    if ($_POST and $_POST['year']) {
        $year = $_POST['year'];
        $sql1 = "SELECT COUNT(*)
                FROM Artworks
                WHERE (year LIKE '$year')";
        $query1 = mysqli_query($link, $sql1);
    } else {
        $year = '';
        $query1 = '';
    }

    # number of artists born or died in a specific nation
    if ($_POST and $_POST['nation']) {
        $nation = $_POST['nation'];
        $sql2 = "SELECT COUNT(*)
                FROM Artists
                WHERE (place_of_birth LIKE '%$nation%' OR place_of_death LIKE '%$nation%')";
        $query2 = mysqli_query($link, $sql2);
    } else {
        $nation = '';
        $query2 = '';
    }
?>

<html lang="it">    
    <head>
        <meta charset="utf-8">
		        
		<title>See stats</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}

		</style>
    </head>
		<button onclick="window.location.href='index.html'">Back to Home</button>
		<h1>See stats</h1>

        <h3>Artworks in a given year</h3>
        <h2><?php if ($query1) echo mysqli_fetch_assoc($query1)['COUNT(*)']; ?></h2>

		<form action="stats.php" method="POST">
			<fieldset>
				<label>Year:</label>
				<input type="text" name="year" value="<?php echo htmlspecialchars($year);?>" autofocus >
			</fieldset>
			<input type="submit" value="Search" />
		</form>

        <h3>Artists born/dead in a given nation</h3>
        <h2><?php if ($query2) echo mysqli_fetch_assoc($query2)['COUNT(*)']; ?></h2>

		<form action="stats.php" method="POST">
			<fieldset>
				<label>Nation:</label>
				<input type="text" name="nation" value="<?php echo htmlspecialchars($nation);?>" autofocus >
			</fieldset>
			<input type="submit" value="Search" />
		</form>
        <?php mysqli_close($link); ?>
    </body>
</html>