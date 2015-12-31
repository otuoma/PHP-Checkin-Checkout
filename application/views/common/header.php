   <div id="top-header">
        <img src="<?php echo base_url(); ?>images/trakka-header.png" height="100px" width="800px">
    </div>

    <nav>
        <ul>
            <li><a href="<?php echo base_url(); ?>index.php/items">Items</a>
                <ul>
                    <li><a href="<?php echo base_url(); ?>index.php/items">All Items</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/items/create_new">Create New</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/items/reports">Reports</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>index.php/persons">Patrons</a>
                <ul>
                    <li><a href="<?php echo base_url(); ?>index.php/persons">All Patrons</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/persons/create_new">Create New</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/persons/reports">Reports</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>index.php/tracker">Checkin Checkout</a>
                <ul>
                    <li><a href="<?php echo base_url(); ?>index.php/items/checkedin_items">Cheked in</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/items/checkedout_items">Checked out</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/tracker/reports">Reports</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo base_url(); ?>index.php/labels">Labels</a>
			</li>
			<li>
				<a href="<?php echo base_url(); ?>index.php/options">Options</a>
			</li>
        </ul>
    </nav>
     <div id="log-details" style="text-align:right; padding-right: 10px;">
         <?php
            if($this->session->userdata('logged_in')){//a bugger's logged in
                
                ?>
                    Logged in as <?php echo $this->session->userdata('first_name'); ?>, 
                    <a href="<?php echo base_url(); ?>index.php/login/patron_logout">log out</a>
                <?php
            }  else {
               ?>Welcome guest, <a href="<?php echo base_url()?>index.php/login">log in</a>.<?php
            }
         ?>
     </div>