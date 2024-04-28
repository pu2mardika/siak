function setSiteURL() { 
	window.site = base_url; 
} 

function format_angka(a)
{
	var bilangan = a;
	
	var	number_string = bilangan.toString(),
	split	= number_string.split(','),
	sisa 	= split[0].length % 3,
	rupiah 	= split[0].substr(0, sisa),
	ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
		
	if (ribuan) {
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}
	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return rupiah;
}

function set_first(){
	show_anim("home/first_page","#icontent");
}

function send_form(formObj,action,responseDIV)
{
    $.ajax({
        url: site+"/"+action, 
        data: $(formObj.elements).serialize(), 
        success: function(response){
                $(responseDIV).html(response);
            },
        type: "post", 
        dataType: "html"
    }); 
    return false;
}

function send_form_loading(formObj,action,responseDIV)
{
    var image_load = "<div class='ajax_loading'></div>";
    $.ajax({
        url: site+"/"+action, 
        data: $(formObj.elements).serialize(),
        beforeSend: function(){
            $(responseDIV).html(image_load);
        },
        success: function(response){
            $(responseDIV).html(response);
        },
        type: "post", 
        dataType: "html"
    }); 
    return false;
}

function show(page,div){
    do_scroll(0);
    var site = base_url;
    var image_load = "<div class='ajax_loading'></div>";

    $.ajax({
      url: site+page,
      beforeSend: function(){
        $(div).html(image_load);
      },
      success: function(response){			
        $(div).html(response);
      },
      dataType:"html"  		
    });
    return false;
}

function show_anim(page,div){
    do_scroll(0);
    var site = base_url;
    var image_load = "<div class='ajax_loading'></div>";
    $.ajax({
      url: site+page,
      beforeSend: function(){
            $(div).html(image_load);
        },
      success: function(response){			
        $(div).html(response);
		$(div).slideDown(200);
      },
      dataType:"html"  		
    });
    return false;
}

function show_silent(page,div){
    do_scroll(0);
    var image_load = "<div class='ajax_loading'></div>";
    $.ajax({
      url: page,
      beforeSend: function(){
            $(div).html(image_load);
        },
      success: function(response){			
        $(div).html(response);
		$(div).slideDown(200);
      },
      dataType:"html"  		
    });
    return false;
}

function load(page,div){
	do_scroll(0);
	var site = base_url;
	var image_load = "<div class='ajax_loading'></div>";
	$.ajax({
	  url: site+""+page,
	  beforeSend: function(){
         $(div).html(image_load);
      },
	  success: function(response){			
	  $(div).html(response);
	  },
	dataType:"html"  		
	});
	return false;
}
 
function load_silent(page,div){
	var site = base_url;
	var $target = $(div);
	$.ajax({
		url: site+"/"+page,
		success: function(response){			
		$(div).html(response);
		//TEST
		$('html, body').stop().animate({
		    'scrollTop': $target.offset().top
		}, 900, 'swing', function () {
		    window.location.hash = div;
		});
		//TEST
		},
	dataType:"html"  		
	});
	return false;
}

function highlightInputs() {
	var inputs = document.getElementsByTagName('input');
	var i;
	for (i=0; i<inputs.length; i++) {
		inputs[i].onfocus = function() {
			this.style.background = '#F6F6F6';
		}
		inputs[i].onblur = function() {
			this.style.background = '#FFF';	
		}
	}
}

function do_scroll(point)
{
	$('html').animate({
		scrollTop: point
	}, 500);
}

function show_notice(msg)
{
	jQuery.noticeAdd({
	      text: msg,
	      stayTime: 5000,   
	      stay: false
	  });
}

function handleEnter (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	}else{
		return true;
	}
}

function printDiv(div) 
{ 
	var site = base_url;
	var css1='<link rel="stylesheet" href="'+base_url+'/assets/styles/bootstrap.min.css">';
	var css2='<link rel="stylesheet" href="'+base_url+'/assets/styles/main.css">';
	var css3='<link rel="stylesheet" href="'+base_url+'/assets/css/table/style.css">';
	var divToPrint=$(div).html(); 
	var newWin=window.open('','Print-Window','width=600,height=600'); 
	newWin.document.open(); 
	newWin.document.write('<html><head><title>'+jdl+'</title>'+css1+css2+css3+'</head><body onload="window.print()">'+divToPrint+'</body></html>'); 
	newWin.document.close(); 
	setTimeout(function(){newWin.close();},3000); 
}  

function myMap(l,b) {
    var mapOptions = {
        center: new google.maps.LatLng(l, b),
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.HYBRID
    }
	var map = new google.maps.Map(document.getElementById("map"), mapOptions);
}
function disableselect(e){
return false
}
function reEnable(){
return true
}
/*
var message="Function right click is Disabled ....!";
function clickIE4(){
    if(event.button==2){
     // alert(message);
      return false;
    }
}
function clickNS4(e){
    if(document.layers||document.getElementById&&!document.all){
      if(e.which==2||e.which==3){
     //   alert(message);
        return false;
      }
    }
  }
if(document.layers){
    document.captureEvents(Event.MOUSEDOWN);
    document.onmousedown=clickNS4;
}else if(document.all&&!document.getElementById){
    document.onmousedown=clickIE4;
}
//document.oncontextmenu=new Function("alert(message);return false");
*/
function doc_keyUp(e,ev,url,div) {

    // this would test for whichever key is 40 and the ctrl key at the same time
    if (e.ctrlKey && e.keyCode == ev) {
        // call your function to do the thing
        //pauseSound();
        //alert(e.keyCode);
        showHelp()
    }
}

function bantuan(e){
	if(e.keyCode==72){
		alert("MINTA BANTUAN");
	}
}

//alert
function show_alert(title, content, icon, timer) {
	Swal.fire({
		title: title,
		text: content,
		icon: icon,
		showConfirmButton: false,
		timer: timer
	})
}

// Sweet alert
function confirmation(ev) {
ev.preventDefault();
var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
console.log(urlToRedirect); // verify if this is the right URL
swal({
  title: "Yakin ingin menghapus data ini?",
  text: "Data yang sudah dihapus tidak dapat dikembalikan",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
  if (willDelete) {
    // Proses ke URL
    window.location.href = urlToRedirect;
  } 
});
} 

// Sweet Ajax alert
function AjaxConfirm(ev) {
ev.preventDefault();
var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
var dtTarget = ev.currentTarget.getAttribute('data-target'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
console.log(urlToRedirect); // verify if this is the right URL
swal({
  title: "Yakin Anda ingin menghapus data ini?",
  text: "Data yang sudah dihapus tidak dapat dikembalikan",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
  if (willDelete) {
    // Proses ke URL
    //window.location.href = urlToRedirect;
    show_silent(urlToRedirect, '#'+dtTarget);
    setTimeout(function () {
        location.reload();
	}, 900);
  } 
});
} 

// register the handler :
document.addEventListener('keyup', doc_keyUp, false); 
$(document).ready(function () {
	var options = {
        beforeSend: function(){
            // Replace this with your loading gif image
            $(".frmmsg").html('<p><img src ="images/ajax.gif" class = "loader" /></p>');
        },
        complete: function(response){
            // Output AJAX response to the div container
            $("#xboard").html(response.responseText);
          //  $('html, body').animate({scrollTop: $("#xboard").offset().top-100}, 150);
            $('#info').fadeOut(6000);
        }
    };
    $(".scroll").click(function(event){		
		event.preventDefault();
		$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
	});
    
    // Submit the form
    $(".contentform").ajaxForm(options);  
  
	$('#info').fadeOut(6000);$("#btnprint").click(function(){window.print()});   
	/*
	document.addEventListener("contextmenu", function(e){
	    e.preventDefault();
	}, false);  */  
});
