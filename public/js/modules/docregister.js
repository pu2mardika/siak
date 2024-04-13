var docregister=function(){
	var anim= base_url + "assets/styles/images/ajax.gif";
	var options = {
	    beforeSend: function(){
	        // Replace this with your loading gif image
	        $(".frmmsg").html('<p><img src ="'+ anim +'" class = "loader" /></p>');
	    },
	    complete: function(response){
	        // Output AJAX response to the div container
	        $("#xboard").html(response.responseText);
	      //  $('html, body').animate({scrollTop: $("#xboard").offset().top-100}, 150);
	        $('#info').fadeOut(6000);
	    }
	};

    return {
		awal:function(){
			if(typeof(EventSource) !== "undefined") {
			    var source = new EventSource("docregister/listdoc");
			    source.onmessage = function(event) {
			        $("#x_result").html(event.data);
			    };
			} else {
			    document.getElementById("x_result").innerHTML = "Sorry, your browser does not support server-sent events...";
			};
		},
		vlist: function(){
			//$("#search_box").focus() 
			$('#search_tgl').datetimepicker({
			    locale: 'en',
			    format: 'DD-MM-YYYY'
			});	
            $("#search_tgl").blur(function(){
				var $k=$("#search_tgl").val();
				load('docregister/listdoc/'+$k,'#x_result');
			});
		},
		init: function(r){			
			$("#tgl").blur(function(){
				var $k=$("#tgl").val();
				load('docregister/genNomor/'+$k,'#d-no_surat');
			});
			
		},
		edit: function(){
			$("#tgl").prop( "disabled", true );
			$("#no_surat").prop( "disabled", true );
		}
	};
}();