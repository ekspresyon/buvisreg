var optionsTab = document.getElementById("vr-more-option")
var lstgenbtn = document.getElementById("listgenbtn")
var listgenbtnplus = document.getElementById("listgenbtnplus")
var xprtbtn = document.getElementById("listxprtbtn")
var linkselector = document.getElementById("linkselector")
//var optlnk = linkselector.options[linkselector.selectedIndex].getAttribute('data-url')
var label1 = document.getElementById("label1")
var label2 = document.getElementById("label2")
var datePicker = document.getElementById("datePicker")
var vrapiRoute = document.getElementById("vrapiRoute")
var cpReqUrl = document.getElementById("cpReqUrl")
var siteurl = document.getElementById("apireqform").action

var vrtbldiv = document.getElementById("vrlinks")
var fetchurl = ""

//optnTrig.addEventListener("change", vrOptndisp)
lstgenbtn.addEventListener("click", mroptn)
listgenbtnplus.addEventListener("click", mroptn)

//xprtbtn.addEventListener("click", listxprt)

function mroptn(event){
	event.preventDefault()

	if(linkselector.value == "optnTrig"){
		var optionslct = document.querySelectorAll(".vrfltroptn")
		var dateslct = document.querySelectorAll(".vrdtfltroptn")
		console.log(optionslct[0].value)
		console.log(dateslct[1].value)

		optlnk = siteurl+"wp-json/visreg/v1/everything?_fields"
		listgen()
	}
	else {
		optlnk = linkselector.options[linkselector.selectedIndex].getAttribute('data-url')
		listgen()
	}
}


// Table row generating loop
function listgen(event){
	vrapiRoute.innerHTML = optlnk
	//event.preventDefault()
	
	fetchurl = optlnk
	console.log("fetch it - -"+fetchurl)

	// Fetch data with API 
	fetch(fetchurl)
	  .then((response) => {
	    return response.json();
	  })
	  .then((vrjsondata) => {
	  	var tablhead = '<thead><tr><th>Post type</th><th>Title</th><th>Permalinks</th><th>Last modified</th></tr></thead>'
		var vrtable = '<table class="wp-list-table widefat fixed striped posts">' + tablhead
		// Generate table rows
		vrjsondata.forEach(function(rowdata){
			vrtable += '<tr><td>' + rowdata.post_type + '</td>'+'<td>' + rowdata.title + '</td>' + '<td>' + rowdata.permalink + '</td>' + '<td>' + rowdata.modified + '</td>'+'</tr>'
		})
		// Close table tag
		vrtable += '</table>'

		// Output table to admin page
		vrtbldiv.innerHTML= vrtable

		cpReqUrl.classList.remove("hide")

	    console.log(vrjsondata);
	  });
}

function listxprt(event){
	//event.preventDefault()
	console.log("list exporter clicked")
}

function vrOptndisp(){
	
	var optnTrig = linkselector.value
	
	if (optnTrig == "0") {
		optionsTab.classList.remove("show-vr-more-option")
		lstgenbtn.classList.remove("hide")
	}
	else{
		optionsTab.classList.add("show-vr-more-option")
		lstgenbtn.classList.add("hide")
	}
}

function vrdatepick(value){
	console.log(value)
	
	var dateinpt = value	
	
	if (dateinpt == "dateRange") {
		datePicker.classList.remove("hide")
	}
	else{
		datePicker.classList.add("hide")
	}
}

// Copy generated API request route to clipboard
function vrAPIurlcopy(){
	const el = document.createElement('textarea');  // Create a <textarea> element
  el.value = vrapiRoute.textContent;                                 // Set its value to the string that you want copied
  el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
  el.style.position = 'absolute';                 
  el.style.left = '-9999px';                      // Move outside the screen to make it invisible
  document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
  const selected =            
    document.getSelection().rangeCount > 0        // Check if there is any content selected previously
      ? document.getSelection().getRangeAt(0)     // Store selection if found
      : false;                                    // Mark as false to know no selection existed before
  el.select();                                    // Select the <textarea> content
  document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
  document.body.removeChild(el);				  // Remove the <textarea> element
  alert("Reqest route for current search copied to keyboard")                  
  if (selected) {                                 // If a selection existed before copying
    document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
    document.getSelection().addRange(selected);   // Restore the original selection
  }  
}