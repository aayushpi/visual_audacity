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
<h1 id="logo"><?php bloginfo('name'); ?></h1>

<?php 
$args = array( 'post_type' => 'mix_tape' );
$loop = new WP_Query( $args );            

if ($loop->have_posts() ): 
$imgcount = 1;?>
<img id="add" src="<?php bloginfo('template_url'); ?>/assets/add-new.png"/>
  <div id="overlay">
    <div>
      <header>
        <div id="close">CLOSE</div>
        <h2>Title</h2>
      </header>
      <img src="http://placehold.it/300x300"/>
      <iframe src="https://embed.spotify.com/?uri=spotify:user:1242949767:playlist:0hEb75cTIysQliH1AOpJUI" width="300" height="330" frameborder="0" allowtransparency="true"></iframe>
    </div>
  </div>
  
    <div id="plus">
    <div>
          <div id="close2">CLOSE</div>
      <?php gravity_form(1, false, false, false, '', true, 12); ?>
    </div>
  </div>


<div id="container">
<?php while ( $loop->have_posts() ) : $loop->the_post(); 
  
    $valuation = get_the_ID();
    $post_class = get_post_meta( $valuation, 'spotify_code_class', true );
    $post_class_2 = get_post_meta( $valuation, 'album_art_class', true );
    $random = (rand(1,3));
?>
	<div class="item">
  	<h2><?php the_title(); ?></h2>
  	<div class="audacity"> </div>
    <a data-title="<?php the_title(); ?>" data-code="<?php echo $post_class;?>"><img src="<?php echo $post_class_2; ?>/media/?size=m" class="pickme image<?php echo $random ?>"/></a>
	</div><?php endwhile; ?>
</div>
<?php else: ?>
<h2>No posts to display</h2>
<?php endif; ?>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>