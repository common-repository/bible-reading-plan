<?php
function ft_brp_widget_content( $args ) {
	extract($args);
	echo $before_widget;
	echo $before_title;
	if ( !$title = get_option('ft_brp_widget_title') ){
		$title = "";
	}
	?>
	<?php echo stripslashes($title); ?>
	<?php
	echo $after_title;
	ft_brp_get_todays_scripture(); 
	echo $after_widget;
}

function ft_brp_get_todays_scripture(){
	global $wpdb;
	$today = date('z');
	(int) $today;
	$today++;
	
	$sql = "SELECT scripture FROM `".$wpdb->prefix."ft_brp` WHERE day = $today";
	
	if ( $verse = $wpdb->get_row($sql) ){
		echo "<p class='ft_brp_scripture'>";
		if ( get_option('ft_brp_widget_linked',true) == 1 ){
			echo "<a href='http://www.biblegateway.com/passage/?search=".$verse->scripture."&version=".get_option('ft_brp_widget_version')."'>";
		}
		echo $verse->scripture;
		if ( get_option('ft_brp_widget_linked',true) == 1 ){
			echo "</a>";
		}
		echo "</p>";
		echo "<p class='ft_brp_provided'><small><a href='http://betweenthetimes.com/bible-reading-plan/'>view complete list</a></small></p>";
	}
}

function ft_brp_widget_controll(){
	global $wpdb;
	if ( isset($_POST['ft_brp_option_submit']) ){
		update_option('ft_brp_widget_title' , $wpdb->prepare($_POST['ft_brp_widget_title']) );
		update_option('ft_brp_widget_linked' , $wpdb->prepare($_POST['ft_brp_widget_linked']) );
		update_option('ft_brp_widget_version' , $wpdb->prepare($_POST['ft_brp_widget_version']) );
	}
	
	// Set current linked option
	if ( get_option('ft_brp_widget_linked' , true ) == 0 ){
		$no_link = 'checked ';
	}else{
		$no_link = '';
	}
	

	// Set the current version
	$nasb = $niv = $kjv = $nkjv = $esv = "";
	if ( $version = get_option('ft_brp_widget_version',true) ){
		switch($version){
			case 49 :
				$nasb = 'selected ';
				break;
			case 31 :
				$niv = 'selected ';
				break;
			case 9 :
				$kjv = 'selected ';
				break;
			case 50 :
				$nkjv = 'selected ';
				break;
			case 47 :
			default:
				$esv = 'selected ';
				break;
		}
	}
	
	if ( !$title = get_option('ft_brp_widget_title') ){
		$title = "";
	}

	?>
	<p>
		<label for="ft_brp_widget_title">Widget Title: </label>
		<input type="text" id="ft_brp_widget_title" name="ft_brp_widget_title" value="<?php echo stripslashes($title);?>" />
	</p>
	<p>
		<label for="ft_brp_widget_linked">Link verse?</label>
		<input type="radio" name="ft_brp_widget_linked" value="1" checked /> Yes |
		<input type="radio" name="ft_brp_widget_linked" value="0" <?php echo $no_link; ?>/> No
		<input type="hidden" name="ft_brp_option_submit" value="1" />
	</p>
	<p>
		<label for="ft_brp_widget_version">Link version:</label>
		<select name="ft_brp_widget_version">
		<option value="47" <?php echo $esv; ?>>ESV</option>
		<option value="49" <?php echo $nasb; ?>>NASB</option>
		<option value="31" <?php echo $niv; ?>>NIV</option>
		<option value="9" <?php echo $kjv; ?>>KJV</option>
		<option value="50" <?php echo $nkjv; ?>>NKJV</option>
		<input type="hidden" name="ft_brp_option_submit" value="1" />
		</select>
	</p>
	<?php
}

function ft_brp_widget_init() {
	$widget_ops = array('classname' => 'ft_brt_widget', 'description' => __( "Lead your readers through the Bible in a year.") );
	wp_register_sidebar_widget('ft_brt_widget', __('Bible Reading Plan'), 'ft_brp_widget_content', $widget_ops);
	wp_register_widget_control('ft_brt_widget', __('Bible Reading Plan'), 'ft_brp_widget_controll' );
}
add_action("plugins_loaded", "ft_brp_widget_init");
?>