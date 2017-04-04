<?php 
if (session_status() == PHP_SESSION_NONE){
	//session_start();
}
require 'includes/functions.php';
require 'config/database.php';
logged_only();
?>
<?php require_once 'includes/header.php'; ?>
<div class="box">
		<table class="main_table">
			<td>
				<div class="box_top">
				<h1 class='titre'>Bienvenue sur Camagru</h1>
					<table>
						<tr>
							<td><img class="filter" src="images/image1.png" class="image_box" alt="visage"></td>
							<td><img class="filter" src="images/image2.png" class="image_box" alt="biere"></td>
							<td><img class="filter" src="images/image3.png" class="image_box" alt="hulk"></td>
							<td><img class="filter" src="images/image4.png" class="image_box" alt="donuts"></td>
						</tr>
						<tr>
							<td><input type="checkbox" id="cbox1" onclick="selectOnlyThis(this.id)"></td>
							<td><input type="checkbox" id="cbox2" onclick="selectOnlyThis(this.id)"></td>
							<td><input type="checkbox" id="cbox3" onclick="selectOnlyThis(this.id)"></td>
							<td><input type="checkbox" id="cbox4" onclick="selectOnlyThis(this.id)"></td>
						</tr>	

					</table>
				</div>
				<div class="picture">
					<video id="video"></video>	
				<div class="button">
					<input 	type="file" name="fileToUpload" id="file" accept="image/x-png">
					<div id="button">
						<input  id="upload" type="submit" value="Utiliser ton image" name="submit">
						<button id="startbutton">Prendre une photo</button>
					</div>
				</div>
					<canvas class="canvas" width="500" height="400" id="canvas"></canvas>
				</div>
			</td>
<?php 
	$picture = picture_taken($pdo, $_SESSION['auth']['id']);
	if ($picture) {
				echo "<td class='picture_taken'>
				<div class='user_picture'>";
					get_user_picture($pdo, $_SESSION['auth']['id']);
					echo"</div>
				</td>
				</table>

				<div class='user_pic_mobile'>";
					get_user_picture($pdo, $_SESSION['auth']['id']);
			echo"</div>
		</div>";
}
?>
<script src="js/camera.js" type="text/javascript"></script>
<script src="js/request.js" type="text/javascript"></script>
<?php require('includes/footer.php') ?>