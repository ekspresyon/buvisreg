<?php ?>

            <h3>Custom search</h3>
                <form id="apireqform" action="<?php echo site_url();?>" method="get" accept-charset="utf-8">
                    <div class="tablenav">
                        <!-- <label id="label1" for="drop1">Choose option:
                            <select id="drop1" onchange="vrdemo(this.value)">
                                <option value="0">- Select option -</option>
                                <option value="1" disabled>Post types</option>
                                <option value="2">Archives</option>
                                <option value="3" disabled="">Categories</option>
                                <option value="4" disabled>Tags</option>
                            </select></label>
                 
                        <label id="label2" for="drop1" class="hide">Archives options:
                        <select id="drop2" onchange="vrdemo(this.value)">
                            <option value="0">- Select option -</option>
                            <option value="2" disabled>Red</option>
                            <option value="3" disabled>Blue</option>
                            <option value="4" >Green</option>
                        </select></label>
                    
                        <label id="label3" for="drop1" class="hide">Green options:
                        <select id="drop3">
                            <option value="0">- Select option -</option>
                            <option value="2">Cian</option>
                            <option value="3">Black</option>
                            <option value="4">Magenta</option>
                        </select></label> -->

                        <select class="vrfltroptn">
                            <option value ="posts" >Posts</option>
                            <option value ="pages" >Pages</option>
                            <!-- <option value="0">All post types</option> -->
                            <?php
                                $args = array(
                                    'public'   => true,
                                    '_builtin'   => false,
                                );
                                $post_types = get_post_types($args, 'objects');
                                 
                                foreach ( $post_types  as $post_type ) {
                                   echo '<option value =' . $post_type->name.'>';
                                   echo $post_type->labels->singular_name;
                                   echo '</option>';
                                }
                            ?>
                        </select>
                        

                        <select class="vrfltroptn">
                            <option value="0">All available links</option>
                            <option value="1">Flagged only</option>
                        </select>
                        <select class="vrdtfltroptn" onchange="vrdatepick(this.value)">
                            <option value="0">Any date</option>
                            <option value="7776000000">Last 90 days</option>
                            <option value="5184000000">Last 60 days</option>
                            <option value="2592000000">Last 30 days</option>
                            <option value="1">Date range</option>
                        </select>

                        <div id="datePicker" class="hide">
                            <label>From :<input type="date" class="vrdtfltroptn" name="startDate" value=""></label>
                            <label>to :<input type="date" class="vrdtfltroptn" name="endDate" value=""></label>
                        </div>
                        
                    </div>  <!-- end .tablenav -->

                    <button id="listgenbtnplus" class="page-title-action button action">
                        Generate list
                    </button>         
                </form>
                <?php 
                
        $avlblpostypes = [];
        $i = 0;

        foreach ( $post_types as $post_type ) {
            $avlblpostypes[$i] = $post_type->name;
            $i++;
        }

        print_r($avlblpostypes);
                ?>
        