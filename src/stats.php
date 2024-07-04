<?php
	$link = mysqli_connect("127.0.0.1", "root", "mypassword", "museo");

    # number of artworks created in a specific year
    if ($_POST and array_key_exists('year', $_POST)) {
        $year = $_POST['year'];
        $sql1 = "SELECT COUNT(*)
                FROM Artworks
                WHERE (year = '$year')";
        $query1 = mysqli_query($link, $sql1);
    } else {
        $year = '';
        $query1 = '';
    }

    # number of artists born or died in a specific nation
    if ($_POST and array_key_exists('nation', $_POST)) {
        $nation = $_POST['nation'];
        $sql2 = "SELECT COUNT(*)
                FROM Artists
                WHERE (birth_state = '$nation' OR death_state = '$nation')";
        $query2 = mysqli_query($link, $sql2);
    } else {
        $nation = '';
        $query2 = '';
    }

    # number of artists born or died in a specific city
    if ($_POST and array_key_exists('city', $_POST)) {
        $city = $_POST['city'];
        $sql3 = "SELECT COUNT(*)
                FROM Artists
                WHERE (birth_city = '$city' OR death_city = '$city')";
        $query3 = mysqli_query($link, $sql3);
    } else {
        $city = '';
        $query3 = '';
    }
    
    # show the artist that made the most artworks
    $sql4 = "SELECT Artists.name, COUNT(*) AS num_artworks
            FROM Artworks
            JOIN Artists ON Artworks.artistId = Artists.id
            GROUP BY Artists.id
            ORDER BY num_artworks DESC
            LIMIT 5";
    $query4 = mysqli_query($link, $sql4);    

    # show the average number of works of a state (of birth)
    if ($_POST and array_key_exists('nation_of_birth', $_POST)) {
        $nation_of_birth = $_POST['nation_of_birth'];
        $sql5 = "SELECT AVG(Subtable.artworks_count)
                FROM Artists
                LEFT JOIN (
                    SELECT artistId, COUNT(*) AS artworks_count
                    FROM Artworks
                    GROUP BY artistId
                ) AS Subtable ON Artists.id = Subtable.artistId
                WHERE Artists.birth_state = '$nation_of_birth'";
        $query5 = mysqli_query($link, $sql5);
    } else {
        $nation_of_birth = '';
        $query5 = '';
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

        <h3>Artists born/dead in a given city</h3>
        <h2><?php if ($query3) echo mysqli_fetch_assoc($query3)['COUNT(*)']; ?></h2>
		<form action="stats.php" method="POST">
			<fieldset>
				<label>City:</label>
				<input type="text" name="city" value="<?php echo htmlspecialchars($city);?>" autofocus >
			</fieldset>
			<input type="submit" value="Search" />
		</form>

        <h3>Artists who made the most artworks</h3>
        <?php if ($query4) { 
            $count = 1;
            while ($fetch = mysqli_fetch_assoc($query4)) {
                echo '<h2>' . $count . ') ' . $fetch['name'] . ' (' . $fetch['num_artworks'] . ')</h2>';
                $count++;
            }
        } ?>

        <h3>Average number of works of a nation (of birth)</h3>
        <h2><?php if ($query5) echo mysqli_fetch_assoc($query5)['AVG(Subtable.artworks_count)']; ?></h2>
        <form action="stats.php" method="POST">
			<fieldset>
				<label>Nation:</label>
				<input type="text" name="nation_of_birth" value="<?php echo htmlspecialchars($nation_of_birth);?>" autofocus >
			</fieldset>
			<input type="submit" value="Search" />
		</form>

        <?php mysqli_close($link); ?>
    </body>
</html>