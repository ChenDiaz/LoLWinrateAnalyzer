function validateForm() {
    var x = document.forms["form"]["user"].value;
    if (x == null || x == "") {
        document.getElementById("user").style.borderColor = "red";
    	return false;
    }
    else {
    	$('#button-jquery').css('background-color','red');
      	$('#button-jquery').html('Loading');
      	return true;
    }
}