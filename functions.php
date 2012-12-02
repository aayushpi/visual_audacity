<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	
	// register_nav_menus(array('primary' => 'Primary Navigation'));

/* ========================================================================================================================
  Kollage Function
/* =======================================================================================================================*/
	
	
	function get_kollage() {
    $valuation = get_the_ID();
    $post_class = get_post_meta( $valuation, 'spotify_code_class', true );

    $images = get_children(
	   array(
	       'order'          => 'ASC',
	       'orderby'		 => 'menu_order ID',
	       'post_parent'    => get_the_ID(),
	       'post_type'      => 'attachment',
	       'numberposts'    => -1, // show all
	       'post_status'    => null,
	       'post_mime_type' => 'image',
	   )
    );
    
    if ( $images ) {
		$id_count = 1;
		foreach( $images as $image ) {
			$imgtag   = wp_get_attachment_image($image->ID,'medium');		
			$atturl   = wp_get_attachment_url($image->ID);
			echo '<div data-original="'.$atturl.'" id="'.$id_count.'" class="image">';
			echo '<a href="'.$post_class.'">'.$imgtag.'</a>';
			echo '</div>';
			$id_count++;			
		}		
	}
}
/* ========================================================================================================================
  Custom Post Type
/* =======================================================================================================================*/

	
	
	//Custom Post Type Start
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'mix_tape',
		array(
  		'supports' => array( 'title', 'thumbnail', 'custom-fields'),
			'labels' => array(
				'name' => __( 'Mixtapes' ),
				'singular_name' => __( 'Mixtape' )
			),
		'public' => true,
		'has_archive' => true,
		)
	);
}

	
	/* ========================================================================================================================
  	Custom Box for Spotify Code
	/* ========================================================================================================================
  /* Fire our meta box setup function on the post editor screen. */
  add_action( 'load-post.php', 'spotify_code_setup' );
  add_action( 'load-post-new.php', 'spotify_code_setup' );
  
  /* Meta box setup function. */
  function spotify_code_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'spotify_code_meta_boxes' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'spotify_code_class_meta', 10, 2 );
	}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function spotify_code_meta_boxes() {

	add_meta_box(
		'spotify-code-class',			// Unique ID
		esc_html__( 'Post Class', 'example' ),		// Title
		'spotify_code_meta_box',		// Callback function
		'post',					// Admin page (or post type)
		'side',					// Context
		'default'					// Priority
	);
}

/* Save the meta box's post metadata. */
function spotify_code_class_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['spotify_code_class_nonce'] ) || !wp_verify_nonce( $_POST['spotify_code_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
//	$new_meta_value = ( isset( $_POST['spotify-code-class'] ) ? sanitize_html_class( $_POST['spotify-code-class'] ) : '' );
    $new_meta_value = ( $_POST['spotify-code-class'] );

	/* Get the meta key. */
	$meta_key = 'spotify_code_class';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}



/* Display the post meta box. */
function spotify_code_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'spotify_code_class_nonce' ); ?>

	<p>
		<label for="spotify-code-class"><?php _e( "Add a custom CSS class, which will be applied to WordPress' post class.", 'example' ); ?></label>
		<br />
		<input class="widefat" type="text" name="spotify-code-class" id="spotify-code-class" value="<?php echo esc_attr( get_post_meta( $object->ID, 'spotify_code_class', true ) ); ?>" size="30" />
	</p>
<?php }



	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'script_enqueuer' );

	add_filter( 'body_class', 'add_slug_to_body_class' );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */



	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function script_enqueuer() {
		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'screen', get_template_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
	}	

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}