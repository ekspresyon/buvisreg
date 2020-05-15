var vrsiteurl = document.getElementById("vrsiteUrl").textContent
var typeCheck = document.getElementById("visred-pt-list").querySelectorAll('input')

var optionsTab = document.getElementById("vr-more-option")

var lstgenbtn = document.getElementById("listgenbtn")
var listgenbtnplus = document.getElementById("listgenbtnplus")
var xprtbtn = document.getElementById("listxprtbtn")
var linkselector = document.getElementById("linkselector")
//var optlnk = linkselector.options[linkselector.selectedIndex].getAttribute('data-url')
var label1 = document.getElementById("label1")
var label2 = document.getElementById("label2")
var datePicker = document.getElementById("datePicker")
var dateslct = document.querySelectorAll(".vrdtfltroptn")
var optionslct = document.querySelectorAll(".vrfltroptn")
var vrapiRoute = document.getElementById("vrapiRoute")
var vrapiBash = document.getElementById("vrapiBash")

var cpReqUrl = document.getElementById("cpReqUrl")

// Not being used for now
// var siteurl = document.getElementById("apireqform").action

var vrlnkgen = document.getElementById("vrlinksgen")
var vrtbldiv = document.getElementById("vrlinks")
var fetchurl = ""



for (var i = 0 ; i < typeCheck.length; i++) {
	typeCheck[i].addEventListener('change', genapiroute)
}

//vrapiRoute.addEventListener('load', console.log("link loaded"))
window.onload = genapiroute

function genapiroute(){
	var dflbsh = "curl "+vrsiteurl+"/wp-json/visreg/v1/someposts | jq '.[]' | tr -d '\"' >> urls.txt"
	var dflturl = vrsiteurl+"/wp-json/visreg/v1/someposts"
	var optlnk = vrsiteurl+"/wp-json/visreg/v1/someposts?ptselect="
	var typearray=[]
	// Build the link
	for (var i = 0 ; i < typeCheck.length; i++) {
		if(typeCheck[i].checked){
			typearray.push(typeCheck[i].value)
		}
		else{
			continue
		}
		
	}
	if(typearray.length > 0){
		typearray = typearray.toString()
		// Display the link
		vrapiBash.innerHTML = "curl "+optlnk+typearray+" | jq '.[]' | tr -d '\"' >> urls.txt"
		vrapiRoute.innerHTML = optlnk+typearray
	}
	else{
		vrapiBash.innerHTML = dflbsh
		vrapiRoute.innerHTML = dflturl	
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
	  	console.log(vrjsondata[0]);
	  	var tablhead = '<thead><tr><th>Post type</th><th>Title</th><th>Permalinks</th><th>Last modified</th></tr></thead>'
		var vrtable = '<table class="wp-list-table widefat fixed striped posts">' + tablhead
		// Generate table rows
		vrjsondata.forEach(function(rowdata){
			vrtable += '<tr><td>' + rowdata.type + '</td>'+'<td>' + rowdata.title + '</td>' + '<td>' + rowdata.link + '</td>' + '<td>'+rowdata.modified+'</td>'+'</tr>'
		})
		// Close table tag
		vrtable += '</table>'

		// Output table to admin page
		vrtbldiv.innerHTML= vrtable

		cpReqUrl.classList.remove("hide")

	    
	  });
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
// Copy generated API request route to clipboard
function vrAPIbshcopy(){
	const el = document.createElement('textarea');  // Create a <textarea> element
  el.value = vrapiBash.textContent;                                 // Set its value to the string that you want copied
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
  alert("Reqest script for current search copied to keyboard")                  
  if (selected) {                                 // If a selection existed before copying
    document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
    document.getSelection().addRange(selected);   // Restore the original selection
  }  
}
