// JavaScript Document
	var loadDaysReq;

		function loadDaysXMLDoc(url) {

			if (window.XMLHttpRequest) {
				loadDaysReq = new XMLHttpRequest();
				loadDaysReq.onreadystatechange = processloadDaysChange;
				loadDaysReq.open("GET", url, true);
				loadDaysReq.send(null);
			}
			else if (window.ActiveXObject) {
				loadDaysReq = new ActiveXObject("Microsoft.XMLHTTP");
				if (loadDaysReq) {
					loadDaysReq.onreadystatechange = processloadDaysChange;
					loadDaysReq.open("GET", url, true);
					loadDaysReq.send();
				}
			}
		}
		
		function processloadDaysChange() {
		
			if(loadDaysReq.readyState == 1){
				//document.getElementById("day_wrapper").innerHTML = '<p style="padding:0px 15px;">Validating...</p>';
			}
			
			// only if loadDaysReq shows "complete"
			if (loadDaysReq.readyState == 4) {
				// only if "OK"
				if (loadDaysReq.status == 200) {
					// the goodnes
					var response = loadDaysReq.responseText;
					
					//Show the results
					document.getElementById("day_wrapper").innerHTML = response;
					
				} 
				else {
					alert("There was a problem retrieving the XML data:\n" + loadDaysReq.statusText);
				}
			}
		}
		
		function loadDay(month) {

			// Input mode
			url = 'includes/scripts/load_days.php?month='+ month;
			loadDaysXMLDoc(url);
			
			// Put in some loader text
			document.getElementById("day_wrapper").innerHTML = '<p style="padding:0px 15px;">Loading day dropdown...</p>';

		}
