
	<?php wp_footer(); ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/jquery.masonry.min.js"></script>
	<script>
	$(document).ready(function() {
  	$('#container').imagesLoaded( function(){
      $('#container').masonry({
        itemSelector: '.item',
        columnWidth: 50,
        gutterWidth: 1
      });
    });
    $('#add').mouseover(function(){
      $(this).animate({
						top: "0px",
					}, 500); 
		  $(this).mouseout(function(){
		          $(this).animate({
						top: "-110px",
					}, 500); 
		  });
    });
    $('.item div').mouseover(function(){
      $(this).fadeOut(1000);
      $(this).parent().children('div').fadeIn(1000);
      $(this).parent().children('h2').fadeIn(1000);
    });
    $('.item div').mouseout(function(){
      $(this).parent().children('h2').fadeOut(1000);
    })
    $('.audacity').click(function(){
      var image = $(this).parent().children('a').children('img').attr('src');
      var spotify= $(this).parent().children('a').data('code');
      var title= $(this).parent().children('a').data('title');
      $('#overlay div img').attr('src',image);
      $('#overlay div h2').text(title);
      $('#overlay div iframe').attr('src','https://embed.spotify.com/?uri='+spotify+'" width="300" height="300" frameborder="0" allowtransparency="true"');
        $('#overlay').fadeIn(1000);
  
      $('#close').click(function(){
          $('#overlay').fadeOut(500);
      });
    });
   
   $('#add').click(function(){
         $('#plus').fadeIn();
         $('#close2').click(function(){
          $('#plus').fadeOut(500);
      }); 
    });
		});
  </script>
  </body>
</html>

