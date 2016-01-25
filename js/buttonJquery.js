function validateForm() {
    var x = document.forms["form"]["user"].value;
    if (x == null || x == "") {
        document.getElementById("user").style.borderColor = "red";
    	return false;
    }
    else {
    	$('#submit-button').css('background-color','red');
      	$('#submit-button').html('Loading');
      	return true;
    }
}