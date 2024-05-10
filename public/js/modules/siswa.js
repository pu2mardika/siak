var siswa=function(){
	var anim= base_url + "assets/styles/images/ajax.gif";
	var vsiswa = {
		
		url: function(phrase) {
		//	var tp = $("#dtp").attr("data-value-type");
			return base_url + "/siswa/getprofil/" + phrase;
		},
		//getValue: 'nik', ''nama'
		getValue: function(element) {
	         var my_value = element.nik + ' | ' + element.nama;
	         return my_value;
	    },

		cssClasses: "fix-autocomplete",
				
		list: {
	      onSelectItemEvent: function() {
	        var dsiswa = $("#srchsiswa").getSelectedItemData().nik; //get the id associated with the selected value
	        $("#noktp").val(dsiswa).trigger("change");
	      }
	    }
	};
    
    return {
		init: function(){
	   		$("input#srchsiswa").easyAutocomplete(vsiswa);  
		},
	};
}();
