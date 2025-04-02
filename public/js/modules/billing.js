var billing=function(){
	var anim= base_url + "assets/styles/images/ajax.gif";
	var vsiswa = {
		
		url: function(phrase) {
		//	var tp = $("#dtp").attr("data-value-type");
			return base_url + "/bill/getprofil/" + phrase;
		},
		//getValue: 'nik', ''nama'
		getValue: function(element) {
	         var my_value = element.noinduk + ' | ' + element.nama;
	         return my_value;
	    },

		cssClasses: "fix-autocomplete",
				
		list: {
	      onSelectItemEvent: function() {
	        var dsiswa = $("#dtname").getSelectedItemData().noinduk; //get the id associated with the selected value
	        var uker = $("#dtname").getSelectedItemData().uker; //get the id associated with the selected value
	        $("#dtnipd").val(dsiswa).trigger("change");
	        $("#dtuker").val(uker).trigger("change");
	      }
	    }
	};
    
    return {
		init: function(){
	   		$("input#dtname").easyAutocomplete(vsiswa);  
		},
	};
}();