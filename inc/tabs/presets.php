


        <div class="api-links tablenav">
            
                <select id="linkselector"  onchange="vrOptndisp(this.value)">
                    <option value="0" data-url="<?php echo site_url();?>/wp-json/visreg/v1/allposts">Flagged</option>
                    <option value="0" data-url="<?php echo site_url();?>/wp-json/visreg/v1/allposts">Posts</option>
                    <option value="0" data-url="<?php echo site_url();?>/wp-json/visreg/v1/allposts">Pages</option>
                    <option value="0" disabled>Random</option>
                    <option value="0" disabled>Manual uploads</option>
                </select>

                <button id="listgenbtn" class="page-title-action button action">
                    Generate list
                </button>
            
            <!-- <a id="listxprtbtn" class="page-title-action api-links-xprt" href="data:application/octet-stream,HELLO-WORLDDDDDDDD" download="test_urls.json">Export list</a>  --> 
            <!-- <button id="listxprtbtn" class="page-title-action button action">
                Export list                
            </button> -->
            
        </div>
        