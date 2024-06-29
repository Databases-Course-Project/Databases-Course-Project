<?php

	$link = mysqli_connect("127.0.0.1", "root", "mypassword", "museo");

	if ($_POST) {
		$name           = $_POST['name'];
		$gender         = $_POST['gender'];
		$year_of_birth  = $_POST['year_of_birth'];
		$year_of_death  = $_POST['year_of_death'];
		$place_of_birth = $_POST['place_of_birth'];
		$place_of_death = $_POST['place_of_death'];
	} else {
		$name           = '';
		$gender         = '';
		$year_of_birth  = '';
		$year_of_death  = '';
		$place_of_birth = '';
		$place_of_death = '';
	}
	$sql = "SELECT *
			FROM Artists
			WHERE (name LIKE '%$name%' AND gender LIKE '%$gender%' AND year_of_birth LIKE '%$year_of_birth%' AND year_of_death LIKE '%$year_of_death%' AND place_of_birth LIKE '%$place_of_birth%' AND place_of_death LIKE '%$place_of_death%')";

	$query = mysqli_query($link, $sql);
?>

<html lang="it">    
    <head>
        <meta charset="utf-8">
		        
		<title>Search Artists</title>
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

		<style>
			body {
				max-width: 1200px;
			}

		</style>
    </head>
		<button onclick="window.location.href='index.html'">Back to Home</button>
		<h1>Search Artists</h1>

		<form action="search_artists.php" method="POST">
			<fieldset>
				<label>Name:</label>
				<input type="text" name="name" value="<?php echo htmlspecialchars($name);?>" autofocus >
			</fieldset>
			<fieldset>
				<label>Gender:</label>
                
				<select name="gender">
                    <option value="" <?php echo htmlspecialchars(($gender == "") ? "selected" : "");?>>Not Selected</option> 
					<option value="M" <?php echo htmlspecialchars(($gender == "M") ? "selected" : "");?>>Male</option>	
					<option value="F" <?php echo htmlspecialchars(($gender == "F") ? "selected" : "");?>>Female</option>	
				</select>
			</fieldset>
			<fieldset>
				<label>Year of Birth:</label>
				<input type="text" name="year_of_birth" value="<?php echo htmlspecialchars($year_of_birth);?>" >
			</fieldset>
			<fieldset>
				<label>Year of Death:</label>
				<input type="text" name="year_of_death" value="<?php echo htmlspecialchars($year_of_death);?>">
			</fieldset>
			<fieldset>
				<label>Place of Birth:</label>
				<input type="text" name="place_of_birth" value="<?php echo htmlspecialchars($place_of_birth);?>">
			</fieldset>
			<fieldset>
				<label>Place of Death:</label>
				<input type="text" name="place_of_death" value="<?php echo htmlspecialchars($place_of_death);?>">
			</fieldset>

			<input type="submit" value="Search" />
		</form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Year od Birth</th>
                    <th>Year of Death</th>
                    <th>Place of Birth</th>
                    <th>Place of Death</th>
                    <th>URL</th>
					<th>Artworks</th>
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
					<td><button onclick="window.location.href='artist_works.php?artist_id=<?php echo htmlspecialchars($row['id']); ?>'">View</button></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php mysqli_close($link); ?>
    </body>
</html>