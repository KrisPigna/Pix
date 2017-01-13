$( window ).load(function() {

    $(window).scroll(function() {
	   if ( $(window).scrollTop() > 300 ) {
		  $('#toTop').fadeIn('slow');
	   } else {
		  $('#toTop').fadeOut('slow');
	   }
    });
    
    $('button[id=delImg]').on('click', function(){
        $timestamp = $(this).siblings('input[id=timestamp]').val();
        $div = $(this).parents('div[class=row]');
        var r = confirm("Delete this image?");
        if (r == 1){
        $.ajax({
            url: "php/functions.php",
            data:'timestamp='+$timestamp,
            type: "POST",
            success:function(data){
                alert("Image deleted");
                $div.remove();
            },
            error:function (){}
        });
        }
    });
});