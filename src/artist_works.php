<?php

	$link = mysqli_connect("127.0.0.1", "root", "mypassword", "museo");

    $sql = "SELECT *
            FROM Artists
            JOIN Artworks ON Artists.id = Artworks.artistId
            WHERE (Artists.id={$_GET['artist_id']})
            ORDER BY Artworks.medium";

	$query = mysqli_query($link, $sql);
?>

<html lang="it">    
    <head>
        <meta charset="utf-8">
		        
		<title>Artworks by <?php echo htmlspecialchars($_GET['artist_name']); ?></title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}

		</style>
    </head>
		<button onclick="window.location.href='index.html'">Back to Home</button>
		<h1>Artworks by <?php echo htmlspecialchars($_GET['artist_name']); ?></h1>
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
                    <td><?php echo htmlspecialchars($row['year']); ?></td>
                    <td><?php echo htmlspecialchars($row['acquisitionYear']); ?></td>
                    <td><?php echo htmlspecialchars($row['medium']); ?></td>
                    <td><?php echo htmlspecialchars($row['width']); ?></td>
                    <td><?php echo htmlspecialchars($row['height']); ?></td>
                    <td><?php echo htmlspecialchars($row['depth']); ?></td>
                    <td><?php echo htmlspecialchars($row['units']); ?></td>
                    <td><?php echo htmlspecialchars($row['creditLine']); ?></td>
                    <td><?php echo htmlspecialchars($row['url']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php mysqli_close($link); ?>
    </body>
</html>