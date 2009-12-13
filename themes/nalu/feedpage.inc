<?php 
if ($auth->is_anonymous ()) {
?>
	<h3>Please login to access this page</h3>
	<p>Don't have an account? <a href="?action=register">Register one!</a></p>
<?php
}
else {
	$feed = new Feed($_GET['feedurl']);
	echo "<h3>" . $feed->get_name() . " - <a class=\"comment-link\" href=?action=fullfeedpage&feedurl=" . urlencode($feed->get_url()) . ">(View full page)</a></h3>";
	echo "<p> " . $feed->get_description() . "</p>";
	echo "<ul>";
		$items = $feed->get_items();
		foreach ($items as $item) {
			//echo "<li><a target=\"blank\" href=?action=read&item="  . urlencode($item->get_url()) . ">" . $item->get_title() . "</a> - <a class=\"comment-link\" href=?action=comment&feed=" . $item->get_url() . "> Add a comment </a></li>";
			echo "<li><a href=?action=itempage&itemurl="  . urlencode($item->get_url()) . ">" . $item->get_title() . "</a> - <a class=\"comment-link\" href=?action=comment&feed=" . $item->get_url() . "> Add a comment </a> " . $item->get_note () . "</li>";
		}
	echo "</ul>";
}
// Idée de feature : faire une page où les feeds sont tous avec leur description en dessous du titre. L'affichage de la page en question marquerait alors tous les flux comme marqués.
?>

