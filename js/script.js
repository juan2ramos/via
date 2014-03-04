

 (function($) { 

  /* SLIDER */
        if ($('.slider').length > 0) {
                $('.slider').flexslider({
                animation: "none",
                slideshow: true,
                prevText: "<",
                nextText: ">" 
              });
        }
  
  /* Form */ 
	$('#contact-form').on("submit", function(e) {
        e.preventDefault();
        var fields = $(':input').serializeArray();
        select = $('.select-styled').text();
        message = $('#message').val();
        fields.push({name: "asunto", value: select});
        fields.push({name: "mensaje", value: message});
        //$("#results").empty();        
        //$('.bar').css("display", "block");

        $.post("email.php", fields, responseForm, 'json');

    });
	function responseForm(r) {
        console.log(r);
        if (r.success == 0) {
        	alert(r.message);
        }
        else{
        	$('#contact-form').css('display','none');
        	$('.form').append( "<span class='message'>"+r.message+"<span>" );
        }
    }
  /* SELECT */
	 $('select').each(function(){
	    var $this = $(this), numberOfOptions = $(this).children('option').length;
	  
	    $this.addClass('select-hidden'); 
	    $this.wrap('<div class="select"></div>');
	    $this.after('<div class="select-styled"></div>');

	    var $styledSelect = $this.next('div.select-styled');
	    $styledSelect.text($this.children('option').eq(0).text());
	  
	    var $list = $('<ul />', {
	        'class': 'select-options'
	    }).insertAfter($styledSelect);
	  
	    for (var i = 0; i < numberOfOptions; i++) {
	        $('<li />', {
	            text: $this.children('option').eq(i).text(),
	            rel: $this.children('option').eq(i).val()
	        }).appendTo($list);
	    }
	  
	    var $listItems = $list.children('li');
	  
	    $styledSelect.click(function(e) {
	        e.stopPropagation();
	        $('div.select-styled.active').each(function(){
	            $(this).removeClass('active').next('ul.select-options').hide();
	        });
	        $(this).toggleClass('active').next('ul.select-options').toggle();
	    });
	  
	    $listItems.click(function(e) {
	        e.stopPropagation();
	        $styledSelect.text($(this).text()).removeClass('active');
	        $this.val($(this).attr('rel'));
	        $list.hide();
	        //console.log($this.val());
	    });
	  
	    $(document).click(function() {
	        $styledSelect.removeClass('active');
	        $list.hide();
	    });

	}); 

})(jQuery);

/** codigo analitycs **/
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48640253-1', 'festivaldeteatro.com.co');
  ga('send', 'pageview');

