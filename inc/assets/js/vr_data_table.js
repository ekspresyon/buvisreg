var lstgenbtn = document.getElementById("listgenbtn")
var xprtbtn = document.getElementById("listxprtbtn")
var linkselector = document.getElementById("linkselector")
var vrtbldiv = document.getElementById("vrlinks")
var fetchurl = ""

lstgenbtn.addEventListener("click", listgen)
xprtbtn.addEventListener("click", listxprt)

function listgen(event){
	event.preventDefault()
	optlnk = linkselector.options[linkselector.selectedIndex].getAttribute('data-url')
	fetchurl = optlnk
	console.log("fetch it - -"+fetchurl)

	// Fetch data with API 
	fetch(fetchurl)
	  .then((response) => {
	    return response.json();
	  })
	  .then((vrjsondata) => {
	  	var tablhead = '<thead><tr><th>Title</th><th>Permalinks</th></tr></thead>'
		var vrtable = '<table class="wp-list-table widefat fixed striped posts">' + tablhead
		// Generate table rows
		vrjsondata.forEach(function(rowdata){
			vrtable += '<tr><td>' + rowdata.title + '</td>' + '<td>' + rowdata.permalink + '</td>' +'</tr>'
		})
		// Close table tag
		vrtable += '</table>'

		// Output table to admin page
		vrtbldiv.innerHTML= vrtable
	    console.log(vrjsondata);
	  });
}

function listxprt(event){
	//event.preventDefault()
	console.log("list expoerter clicked")
}


//var json = [{"id":19,"title":"post x 2","permalink":"http:\/\/wp.local\/2020\/02\/14\/post-x-2\/"},{"id":17,"title":"post ex 1","permalink":"http:\/\/wp.local\/2020\/02\/14\/post-ex-1\/"},{"id":15,"title":"example 3","permalink":"http:\/\/wp.local\/example-3\/"},{"id":13,"title":"exampl2","permalink":"http:\/\/wp.local\/exampl2\/"},{"id":11,"title":"test post","permalink":"http:\/\/wp.local\/2020\/02\/13\/test-post\/"},{"id":2,"title":"Sample Page","permalink":"http:\/\/wp.local\/sample-page\/"},{"id":1,"title":"Hello world!","permalink":"http:\/\/wp.local\/2020\/01\/31\/hello-world\/"},{"id":3,"title":"Privacy Policy","permalink":"http:\/\/wp.local\/privacy-policy\/"}]









