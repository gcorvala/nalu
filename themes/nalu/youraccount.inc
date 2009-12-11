<?php 
if ($auth->is_anonymous ()) {
?>
	<h3>Please login to manage your account</h3>
	<p>Don't have an account? <a href="?action=register">Register one!</a></p>
<?php
}
else {
	echo "<h3>Manage your account options</h3>"; 
?>

	<p>
		<h4>Change your nickname</h4>
		
	</p>

<?php
}
?>


