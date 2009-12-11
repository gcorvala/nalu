<h3><?php echo $feed->get_name(); ?></h3>
<p><?php echo $feed->get_description(); ?></p>
<ul>
<?php
	$items = $feed->get_items();
	foreach ($items as $item) {
		echo "<li><a href=\""  . $item->get_url() . "\">" . $item.get_name() . "</a></li>";
		echo "<br /><p> $item.get_description()</p>";
	}
?>
