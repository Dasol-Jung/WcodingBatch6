function modify(){
    var amjax = new XMLHttpRequest();	
	amjax.open("POST", "../model/AddModifyDB.php", true);	
	amjax.send();	
	amjax.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var result = JSON.parse(this.responseText);
            document.location.href = "http://localhost:8888/weekschedule";
        }
    }
}