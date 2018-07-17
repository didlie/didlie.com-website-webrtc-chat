<script>
var chatAjax = (callbackFunction,ice='') => {
    userConsole.innerHTML += (".");
			var xxXhttp = new XMLHttpRequest();
			xxXhttp.onreadystatechange = function() {
					if (xxXhttp.readyState == 4 && xxXhttp.status ==200){
								if(xxXhttp.responseText){
											callbackFunction(xxXhttp.responseText);
								};
						};
			};

            var file = "?chat=<?php echo urlencode($_POST['location']->encoded); ?>";
            if(ice.length > 10) file += "&ice=" + ice;

			xxXhttp.open('GET',file, true);
			xxXhttp.send();
            return xxXhttp;
		}
var chatJax = chatAjax;
</script>
