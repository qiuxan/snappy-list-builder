<?php
	/*
		Plugin Name: snappy list builder
		Plugin URI: https://HEHEH
		Description: LALALA
		Version: 0.1.0
		Author: XIAN QIU
		Author URI: http://health-check-team.example.com
 		
	*/
	
	
	
	
	/* !0. TABLE OF CONTENTS */

/*
	
	1. HOOKS

	
	2. SHORTCODES

	3. FILTERS
	
		
	4. EXTERNAL SCRIPTS
		
		
	5. ACTIONS
				
		
	6. HELPERS
		
		
	7. CUSTOM POST TYPES
			
	8. ADMIN PAGES
			
	9. SETTINGS
		
	10. MISC.

*/


/* !1. HOOKS */

// 1.1
// hint: registers all our custom shortcodes on init
	
	
add_action('init', 'slb_register_shortcodes');
	
add_filter('manage_edit-slb_subscriber_columns','slb_subscriber_column_headers');
add_filter('manage_edit-slb_list_columns','slb_list_column_headers');		
//add_filter('manage_slb_subscriber_posts_columns','slb_subscriber_column_data',1,2);

add_filter('manage_slb_subscriber_posts_custom_column','slb_subscriber_column_data',1,2);

add_filter('manage_slb_list_posts_custom_column','slb_list_column_data',1,2);



add_action('admin_head-edit.php','slb_register_custom_admin_titles');
/* !2. SHORTCODES */

// 2.1
// hint: registers all our custom shortcodes



// hint: registers all our custom shortcodes
function slb_register_shortcodes() {
	
	add_shortcode('slb_form', 'slb_form_shortcode');
	
}

// 2.2
// hint: returns a html string for a email capture form
function slb_form_shortcode( $args, $content="") {
	
		$list_id = 0;
		if(isset($args['id'])) $list_id=(int )$args['id'];
		 $output='
		 	<div class="slb">
		 		<form  
		 		id="slb_form" class="slb-form" name="slb_form" method="post"
		 		action="/wp-admin/admin-ajax.php?action=slb_save_subscription"
		 		>
		 		<input type="hidden" name="slb_list"  value="'.$list_id.'"/>
		 			<p class="slb-input-container">
		 				<label> Your name</label><br/>
		 				<input type="text" name="slb_fname" placeholder="First Name"/>
		 				<input type="text" name="slb_lname" placeholder="Last Name"/>
		 			</p>';
		 			if(strlen($content)):
		 			 $output.='<div class=slb-content>'.wpautop($content).'</div>';
		 			endif;
		 			
		 			$output.='<p class="slb-input-container">
		 				<label> Email</label><br/>
		 				<input type="text" name="email" placeholder="email"/>
		 			</p>
		 			<p class="slb-input-container">
		 				<input type="submit" name="slb-submit" value="Sign me up" />
		 			</p>
		 		
		 		</form>
		 	</div>
		 	
		 ';
	
	
	// return our results/html
	return $output;
	
}

	
	
/* !3. FILTER */

function slb_subscriber_column_headers($columns){
	
	$columns=array(
		'cb'=>'<input type="checkbox" />',
		'title'=>__('Subscriber Name'),
		'email'=>__('Email Address'),
	);
	
	return $columns;
}
/*


function slb_subscriber_column_data( $column, $post_id ) {
	
	// setup our return text
	$output = '';
	
	switch( $column ) {
		case 'email':
			// get the custom email data
			$email = get_field('slb_email', $post_id );
			$output .= $email;
			break;
		
	}
	
	// echo the output
	echo $output;
	
}
*/

function slb_subscriber_column_data($column, $post_id){
	
	$output='';
	
	switch($column){
		case 'title':
			$fname=get_field('slb_fname',$post_id);
			$lname=get_field('slb_lname',$post_id);
			$output=$fname .' '.$lname;
			break;
		
		case 'email':
			$email=get_field('slb_email',$post_id);
			$output=$email;
			break;
		
	}
	
	echo $output;
	  
}
/*
function slb_register_custom_admin_titles(){
	add_filter('the_title',
	'slb_custom_admin_titles',
	99,
	2
	);
	
}
*/
function slb_register_custom_admin_titles() {
    add_filter(
        'the_title',
        'slb_custom_admin_titles',
        99,
        2
    );
}

function slb_custom_admin_titles($title, $post_id){
	global $post;
	$output =$title;
	
	if(isset($post->post_type)):
		switch($post->post_type){
			case 'slb_subscriber':
				$fname=get_field('slb_fname', $post_id);
				$lname=get_field('slb_lname', $post_id);
				$output = $fname .' '. $lname;

				break;
		}
	endif; 
	return $output; 
}



function slb_list_column_headers($columns){
	
	$columns=array(
		'cb'=>'<input type="checkbox" />',
		'title'=>__('List Name'),
	);
	
	return $columns;
}


function slb_list_column_data($column, $post_id){
	
	$output='';
	
	switch($column){
		case 'example':
/*
			$fname=get_field('slb_fname',$post_id);
			$lname=get_field('slb_lname',$post_id);
			$output=$fname .' '.$lname;
*/
			break; 
		
	}
	
	echo $output;
	  
}


/* !5. Action */
function slb_save_subscription(){
	
	//setup default result data
	
}