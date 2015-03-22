<?php 

/**
 * Plugin Name:		Famax-Fun
 * Description: 	Display your Facebook FanPage Posts on your website!
 * Version: 		1.1
 * Author: 			CodeHandling
 * Author URI: 		http://www.codehandling.com/
 */

//Register the scripts early 
add_action( 'wp_enqueue_scripts', 'famaxfun_register_scripts' );
function famaxfun_register_scripts() {
	wp_register_style( 'famaxfun-css', plugins_url( 'css/famax.min.css' , __FILE__ ),array(),'1.0' );
	wp_register_script( 'famaxfun-src', plugins_url( 'js/famax.min.js' , __FILE__ ), array('jquery'),'1.0',true);

}

//Shortcode for Famax
add_shortcode('famaxfun', 'famaxfun_init');
function famaxfun_init($atts,$content = null) {

	$post_id = get_the_ID();
	if($post_id==null||$post_id=="") {
		$post_id = 0;
	}

	//Enqueue scripts
	wp_enqueue_script('famaxfun-src');
	wp_enqueue_style( 'famaxfun-css');

	//extract shortcode attributes and assign defaults
	extract(
		shortcode_atts( array(
			'facebook_page_url' => '',
			'fb_access_token' => '',
			'famax_widget_width' => '800px',
			'famax_widget_height' => '',
			'famax_columns' => '2',
			'famax_result_count' => '10'
    	), $atts, 'famaxfun' )
    );	
	

	//$famaxData = '{"appId":"'.$app_id.'","appSecret":"'.$app_secret.'"';
	$famaxData = '{"fbAccessToken":"'.$fb_access_token.'"';
	$famaxData = $famaxData.',"facebookPageUrl":"'.$facebook_page_url.'"';
	
	if($famax_widget_width!="") {
		$famaxData = $famaxData.',"famaxWidgetWidth":"'.$famax_widget_width.'"';
	}
	
	if($famax_widget_height!="") {
		$famaxData = $famaxData.',"famaxWidgetHeight":"'.$famax_widget_height.'"';
	}
	
	if($famax_columns!="") {
		$famaxData = $famaxData.',"famaxColumns":'.$famax_columns;
	}
	
	if($famax_result_count!="") {
		$famaxData = $famaxData.',"famaxResultCount":'.$famax_result_count;
	}	
	
	$famaxData = $famaxData.'}';
	
	//escape spaces
	$famaxData = str_replace(' ', '%20', $famaxData);
	
	//Insert Famax HTML
	return '<div id="famax" data-famax-options='.$famaxData.'></div>';

}

?>