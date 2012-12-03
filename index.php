<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<h2><a href="./add-a-mixtape/">Add a Mixtape</a>
<?php 
$args = array( 'post_type' => 'mix_tape' );
$loop = new WP_Query( $args );            

if ($loop->have_posts() ): ?>
<ul id="baraja-el" class="baraja-container">
<?php while ( $loop->have_posts() ) : $loop->the_post(); 
  
    $valuation = get_the_ID();
    $post_class = get_post_meta( $valuation, 'spotify_code_class', true );
    $post_class_2 = get_post_meta( $valuation, 'album_art_class', true );

?>
	<li>
			<h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    <a href="<?php echo $post_class; ?>"><img src="<?php echo $post_class_2; ?>/media/?size=l"/></a>
    <iframe src="https://embed.spotify.com/?uri=<?php echo $post_class; ?>"width="300" height="380" frameborder="0" allowtransparency="true"></iframe>
	</li>
<?php endwhile; ?>
</ul>
<?php else: ?>
<h2>No posts to display</h2>
<?php endif; ?>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>