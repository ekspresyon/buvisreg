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
var cpReqUrl = document.getElementById("cpReqUrl")
var siteurl = document.getElementById("apireqform").action

var vrtbldiv = document.getElementById("vrlinks")
var fetchurl = ""

//optnTrig.addEventListener("change", vrOptndisp)
lstgenbtn.addEventListener("click", mroptn)
listgenbtnplus.addEventListener("click", mroptn)
dateslct[1].addEventListener("change", setMaxMindate)
dateslct[2].addEventListener("change", setMaxMindate)

//xprtbtn.addEventListener("click", listxprt)
function setMaxMindate(){
	if(dateslct[2] !== null){
		maxDate = dateslct[2].value
		dateslct[1].setAttribute("max", maxDate)
	}
	if(dateslct[1] !== null){
		minDate = dateslct[1].value
		dateslct[2].setAttribute("min", minDate)
	}
}

function mroptn(event){
	event.preventDefault()


	if(linkselector.value == "optnTrig"){
		/*
			How to filter request by date?
			** After select date: ...&after=2020-04-08T00:00:00
			** Before select date: ...&before=2020-04-08T00:00:00

			How to filter by category?
			** TBD

			How to filter by post type?
			** In progress

			How to filter by by meta value?
			** Find meta key: ...&meta_key=_vr_status_key
			** Find meta value: ...&meta_value=true
		
	  	*/
		
		type = optionslct[0].value+"?" // Post type parameter output to URL



		/*
		* This segment sets up the flagging filtering option
		*/
		if(optionslct[1].value == 0){
			flag = ""
		}
		else{
			flag = "filter[meta_key]=_vr_status_key&filter[meta_value]=1"
		}

		//flag = optionslct[1].value // Flagging parameter output to URL


		/*
		* This segment sets up the Date filtering option
		*/
		
		afterDate = "&after=" + dateslct[1].value +"T00:00:00"
		beforeDate = "&before=" + dateslct[2].value +"T00:00:00"

		
		switch (dateslct[0].value){
			case '0' : // When no date is selected
			date = ""
			console.log("no date selected")
			break
			case '1' : // When manual select options are made
				if(dateslct[1].value == null){
					date = afterDate

				}else if (dateslct[2].value == null){
					date = beforeDate

				}else{
					date = afterDate+ beforeDate

				}
				console.log(date)
			break
			default : // When quick Selections are made
			x = dateslct[0].value // go back x number of days!
			d = new Date() // today!
			dm = d - x
			dmFormat = new Date(dm).toISOString().split('T')[0]+"T00:00:00" // format the date for output
			date = "&after="+dmFormat
		}

		// Build the link
		optlnk = siteurl+"/wp-json/wp/v2/"+ type + flag + date //+ "&_fields=id,type,title,link,modified"
		listgen()
	}
	else {

		// If advanced filtering not in use just use quicl select links
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
			vrtable += '<tr><td>' + rowdata.type + '</td>'+'<td>' + rowdata.title.rendered + '</td>' + '<td>' + rowdata.link + '</td>' + '<td>' + rowdata.modified.toLocaleString() + '</td>'+'</tr>'
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
	
	if (dateinpt == "1") {
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








