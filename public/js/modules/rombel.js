var rombel=function(){
	var anim= base_url + "assets/styles/images/ajax.gif";
	var vtendik = {
		
		url: function(phrase) {
		//	var tp = $("#dtp").attr("data-value-type");
			return base_url + "/rombel/dtwali/" + phrase;
		},
		//getValue: 'nik', ''nama'
		getValue: function(element) {
	         var my_value = element.nik + ' | ' + element.nama;
	         return my_value;
	    },

		cssClasses: "fix-autocomplete",
				
		list: {
	      onSelectItemEvent: function() {
	        var walikelas = $("#srcwalikelas").getSelectedItemData().nik; //get the id associated with the selected value
	       // var cid = $("#search_box").getSelectedItemData().noinduk;
	     //   var mid = $("#walikelas").getSelectedItemData().member_id;
	      //  $("#regId").val(cid).trigger("change"); //copy it to the hidden field
	        $("#walikelas").val(walikelas).trigger("change");
	      //  $("#regId").val(mid).trigger("change");
	      }
	    }
	};
    
    return {
		init: function(){
	   		$("input#srcwalikelas").easyAutocomplete(vtendik);  
	   		/*$("#search_box").focus();
	   	//	$(".contentform").ajaxForm(options);
	   	//	$("#btn_cari").click(function(){$(".contentform").submit();});
	   		$(".chgtp").click(function(){
	   		    var tp=$(this).attr("data-tp");
	   		    var thn=$(this).attr("data-thn");
	   		    $("#itp").val(tp);
	   		    $("#dtp").attr("data-value-type",tp);
	   		    load('spp/chgTP/'+tp,"#dtp");
	   		});
	   		*/
		},
	};
}();
