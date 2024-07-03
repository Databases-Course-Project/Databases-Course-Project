<?php

	$link = mysqli_connect("127.0.0.1", "root", "mypassword", "museo");

	if ($_POST) {
		$name           = $_POST['name'];
		$gender         = $_POST['gender'];
		$year_of_birth  = $_POST['year_of_birth'];
		$year_of_death  = $_POST['year_of_death'];
		$birth_city     = $_POST['birth_city'];
		$birth_state    = $_POST['birth_state'];
		$death_city     = $_POST['death_city'];
		$death_state    = $_POST['death_state'];
	} else {
		$name           = '';
		$gender         = '';
		$year_of_birth  = '';
		$year_of_death  = '';
		$birth_city     = '';
		$birth_state    = '';
		$death_city     = '';
		$death_state    = '';
	}
	$sql = "SELECT Artists.*, COUNT(Artworks.id)
			FROM Artists
			LEFT JOIN Artworks ON Artists.id = Artworks.artistId
			WHERE (name LIKE '%$name%' AND gender LIKE '%$gender%' AND year_of_birth LIKE '%$year_of_birth%' AND year_of_death LIKE '%$year_of_death%' AND birth_city LIKE '%$birth_city%' AND birth_state LIKE '%$birth_state%' AND death_city LIKE '%$death_city%' AND death_state LIKE '%$death_state%')
			GROUP BY Artists.id";

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
				<label>Birth City:</label>
				<input type="text" name="birth_city" value="<?php echo htmlspecialchars($birth_city);?>">
			</fieldset>
			<fieldset>
				<label>Birth State:</label>
				<input type="text" name="birth_state" value="<?php echo htmlspecialchars($birth_state);?>">
			</fieldset>
			<fieldset>
				<label>Death City:</label>
				<input type="text" name="death_city" value="<?php echo htmlspecialchars($death_city);?>">
			</fieldset>
			<fieldset>
				<label>Death State:</label>
				<input type="text" name="death_state" value="<?php echo htmlspecialchars($death_state);?>">
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
                    <th>Birth City</th>
                    <th>Birth State</th>
                    <th>Death City</th>
                    <th>Death State</th>
                    <th>URL</th>
					<th>Artworks</th>
					<th>Num of Artworks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars(($row['year_of_birth'] != 0) ? $row['year_of_birth'] : '-'); ?></td>
                    <td><?php echo htmlspecialchars(($row['year_of_death'] != 0) ? $row['year_of_death'] : '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['birth_city']); ?></td>
                    <td><?php echo htmlspecialchars($row['birth_state']); ?></td>
                    <td><?php echo htmlspecialchars($row['death_city']); ?></td>
                    <td><?php echo htmlspecialchars($row['death_state']); ?></td>
					<td><a href="<?php echo htmlspecialchars($row['url']); ?>"><?php echo htmlspecialchars($row['url']); ?></a></td>
					<td><button onclick="window.location.href='artist_works.php?artist_id=<?php echo htmlspecialchars($row['id']); ?>&artist_name=<?php echo htmlspecialchars($row['name']); ?>'">View</button></td>
					<td><?php echo htmlspecialchars($row['COUNT(Artworks.id)']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php mysqli_close($link); ?>
    </body>
</html>