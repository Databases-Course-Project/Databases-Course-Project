<?php

	$link = mysqli_connect("127.0.0.1", "root", "mypassword", "museo");

	if ($_POST) {
        $accession_number = $_POST['accession_number'];
		$title            = $_POST['title'];
		$year             = $_POST['year'];
        $medium           = $_POST['medium'];
	} else {
        $accession_number = '';
		$title            = '';
		$year             = '';
        $medium           = '';
	}
    $sql = "SELECT *
            FROM Artworks
            WHERE (accession_number LIKE '%$accession_number%' AND title LIKE '%$title%' AND year LIKE '%$year%' AND medium LIKE '%$medium%')
            LIMIT 10000";

	$query = mysqli_query($link, $sql);
?>

<html lang="it">    
    <head>
        <meta charset="utf-8">
		        
		<title>Search Artworks</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}

		</style>
    </head>
		<button onclick="window.location.href='index.html'">Back to Home</button>
		<h1>Search Artworks</h1>

		<form action="search_artworks.php" method="POST">
			<fieldset>
				<label>Accession Number:</label>
				<input type="text" name="accession_number" value="<?php echo htmlspecialchars($accession_number);?>" autofocus >
			</fieldset>
			<fieldset>
				<label>Title:</label>
				<input type="text" name="title" value="<?php echo htmlspecialchars($title);?>" >
			</fieldset>
			<fieldset>
				<label>Year:</label>
				<input type="text" name="year" value="<?php echo htmlspecialchars($year);?>">
			</fieldset>
			<fieldset>
				<label>Medium:</label>
				<input type="text" name="medium" value="<?php echo htmlspecialchars($medium);?>">
			</fieldset>
			<input type="submit" value="Search" />
		</form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Accession Number</th>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Year</th>
                    <th>Acquisition Year</th>
                    <th>Medium</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Depth</th>
                    <th>Unit</th>
                    <th>Credits</th>
                    <th>URL</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['accession_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['artist']); ?></td>
                    <td><?php echo htmlspecialchars(($row['year']) ? $row['year'] : '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['acquisitionYear']); ?></td>
                    <td><?php echo htmlspecialchars($row['medium']); ?></td>
                    <td><?php echo htmlspecialchars($row['width']); ?></td>
                    <td><?php echo htmlspecialchars($row['height']); ?></td>
                    <td><?php echo htmlspecialchars($row['depth']); ?></td>
                    <td><?php echo htmlspecialchars($row['units']); ?></td>
                    <td><?php echo htmlspecialchars($row['creditLine']); ?></td>
					<td><a href="<?php echo htmlspecialchars($row['url']); ?>"><?php echo htmlspecialchars($row['url']); ?></a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php mysqli_close($link); ?>
    </body>
</html>