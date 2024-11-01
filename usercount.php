<?php
/*
Plugin Name: WP User count
Plugin URI: http://eris.nu/wordpress/usercount
Description: Show user count
Author: Jaap Marcus
Version: 0.2
Author URI: http://schipbreukeling.nl
*/

class wpusercount extends WP_Widget
{
	//init
	function wpusercount()
	{
		$widget_ops = array( 'classname' => 'wp-user-count', 'description' => 'Show the current number of users' );
		$this->WP_Widget( 'WPusercount', 'WP user count', $widget_ops);
	}
	//Laat de widget zien
	function widget($args, $instance)
	{
		global $wpdb;
		$title = empty($instance['title']) ? '' : $instance['title'];
		$text = empty($instance['text']) ? 'Subscribers: %d' : $instance['text'];
		extract($args);
		$usercount = $wpdb -> get_var('SELECT COUNT(ID) FROM '.$wpdb -> prefix.'users');

		echo $before_widget . $before_title . $title . $after_title;
		echo sprintf($text, $usercount);
		echo $after_widget;
	}

	function update( $new, $old )
	{
		$old['text'] = $new['text'];
		$old['title'] = $new['title'];
		return $old;
	}


	function form($instance)
	{
		if (empty($instance['text'])) {
			$instance['text'] = 'Subscribers: %d';
		}
		if (empty($instance['title'])) {
			$instance['title'] = '';
		}
?>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>"
		value="<?php echo $instance['title']; ?>" /></label><br />
		<label for="<?php echo $this->get_field_id( 'text' ); ?>">Text:
		<input type="text" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"
		value="<?php echo $instance['text']; ?>" /></label><br />
		 %d for number of users
	<?php
	}

}
/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'wpusercountwidget' );
function wpusercountwidget()
{
	register_widget( 'wpusercount' );
}


?>