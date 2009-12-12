<?php 
if ($auth->is_anonymous ()) {
?>
	<h3>Please login to access this page</h3>
	<p>Don't have an account? <a href="?action=register">Register one!</a></p>
<?php
}
else {
	$item = new Item($_GET['itemurl']); 
	echo "<h3>" . $item->get_title() . "</h3>"; 
	echo $item->get_description();
}
?>
