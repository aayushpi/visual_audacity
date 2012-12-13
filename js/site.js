
	jQuery(document).ready(function($) {

		// Your JavaScript goes here
    $('#input_1_3').focusout(function(){
      var index = $(this).val();
      index = index.split('');
      if (index[index.length-1]){
        index.pop();
        index = index.join('');
        $('#input_1_3').val(index);
      }
    })
	});

