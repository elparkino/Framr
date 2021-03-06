/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



var pjWidgetHolder = $;
var $ = jQuery;

var frames = [
	{
		src: "http://framemytv.com/images/gallery/41/FrameMyTV1083.jpg",
		price: 10,
		classlist: ["frame"],
		id: ""
	},
	{
		src: "http://framemytv.com/images/gallery/46/FrameMyTV1123.jpg",
		price: 20,
		classlist: ["frame"],
		id: ""
	},
	{
		src: "http://www.oilpaintingsframes.com/images/6inch_franklin_gold-thumb.jpg",
		price: 30,
		classlist: ["frame"],
		id: ""
	},
	{
		src: "https://farm5.staticflickr.com/4061/4264460638_a4226e4b8a_o.jpg",
		price: 30,
		classlist: ["frame"],
		id: ""
	},
	
];
  
  $(document).ready(function() {

    // console.log(FramerPlugin);
    
    DoFramrFunction("queryFrames", function(data){
      console.log(data);
      testContainer = JSON.parse(data);
    });

  	$.each(frames, function(idx,el){
  		var img = document.createElement("img");
  		var li = document.createElement("li");
  		img.src = this.src;
  		
  		$.each(this.classlist, function(i, e){
  			$(img).addClass(e);
  		});

  		$(li).append(img);
  		$(".frame-list").prepend(li);
  	});

  	var defaultImg = document.createElement('img');
  	defaultImg.src = frames[0].src;
  	$(defaultImg).addClass("selected");
  	//$('.selected-container').append(defaultImg);
    setSliderInit();

  	$('.frame').on("click", handleFrameClick);

    // $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    //   " - $" + $( "#slider-range" ).slider( "values", 1 ) );

    $(".send-quote").on("click", handleSendQuote);


  });
  
  var handleFrameClick = function(e){
      $( ".price-val" ).text("$0");
      $( ".footage-val" ).text("0");
      $(".selected").removeClass("selected");
      $(this).addClass("selected");
      //$('.selected-container').html("");
        var img = document.createElement("img");
        img.src = this.src;

        // $('.selected-container').append(img);
    }

  var handleSendQuote = function(e){
      var attrs = {
        footage: $(".total-footage").text(),
        sender: $(".requester-addy").val()

      }
      SendEmail("parker.emailaddress@gmail.com", attrs, function(data){
        if(data = 1){
          var oldHTML = $(".section-container").html();
          $(".section-container").html("<h1>Thank You!</h1>");
          setTimeout(function(){
            console.log("wtf")
            $(".section-container").html(oldHTML);
          }, 1000);
        }
      })
    };

  var horizontalSliderHandler = function( event, ui ) {
        var selectedIndex = $('.selected').parent().index();

      var verticalInches =  $( ".vertical" ).slider("option", "value");
      var horizontalInches = ui.value;

      var totalInches = ui.value + verticalInches;
      var horizontalFeet = Math.floor(horizontalInches / 12);
      var totalFeet = Math.floor(totalInches / 12);
        var widthPrice = 10 /*frames[selectedIndex].price */* horizontalInches * 2;
        
        var displayTotalInches = totalInches %= 12;
      var displayHorizontalInches = horizontalInches %= 12;

       $('.width').text( horizontalFeet + "' " + displayHorizontalInches + '"');
       $('.total-footage').text( totalFeet + "' " + displayTotalInches + '"');
        var verticalPrice = /*frames[selectedIndex].price */ 10 * verticalInches * 2;
        $( ".price-val" ).text( "$" + (widthPrice + verticalPrice) );
      }

  var verticalSlideHandler = function( event, ui ) {
        var selectedIndex = $('.selected').parent().index();

      var horizontalInches =  $( ".horizontal" ).slider("option", "value");
      var verticalInches = ui.value;
      var totalInches = ui.value + horizontalInches;
      
      var verticalFeet = Math.floor(verticalInches / 12);
      var totalFeet = Math.floor(totalInches / 12);

      var displayVerticalInches = verticalInches %= 12;
        var displayTotalInches = totalInches %= 12;

       $('.height').text( verticalFeet + "' " + displayVerticalInches + '"');
       $('.total-footage').text( totalFeet + "' " + displayTotalInches + '"');

         var heightPrice = /*frames[selectedIndex].price*/ 10 * ui.value * 2;
        
        var widthPrice = /*frames[selectedIndex].price*/10 * $( ".horizontal" ).slider("option", "value") * 2;
        $( ".price-val" ).text( "$" + (widthPrice + heightPrice) );     
      }

  var DoFramrFunction = function(params, SuccessFunction){
        if(params != null && typeof params == 'object'){
          var DataParams = {};
          for(var Key in params){
            DataParams[Key] = params[Key]
          }
        }
        if(params != null && typeof params == 'string'){
          var DataParams = {};
          DataParams.action = params;
        }
        $.ajax({
            url:'/wp-admin/admin-ajax.php', // admin-ajax.php will handle the request
            type:'post',
            data: DataParams,
            success: SuccessFunction
        });

  }

  var SendEmail = function(emailAddress, frameAttrs, callback){
      DoFramrFunction($.extend({
        action: "sendFrameInfo",
        emailAddress: emailAddress
      }, frameAttrs), callback);
  }

  var setSliderInit = function(){
    $( ".horizontal" ).slider({
      min: 0,
      max: 120,
      step: 1,
      slide: horizontalSliderHandler
    });
    $( ".vertical" ).slider({
      orientation: "vertical",
      min: 0,
      max: 120,
      step: 1,
      // values: [ 75, 300 ],
      slide: verticalSlideHandler
    });
  }


