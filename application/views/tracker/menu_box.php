<div id="top-header">
        <img src="<?php echo base_url(); ?>/images/trakka-header.png" height="100px" width="800px">
    </div>

    <nav>
        <ul>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/items">Items</a>
                <ul>
                    <li><a href="<?php echo base_url(); ?>index.php/items">All Items</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/items/create_new">Create New</a></li>
                    
                </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>index.php/persons">Patrons</a>
                <ul>
                    <li><a href="<?php echo base_url(); ?>index.php/persons">All Patrons</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/persons/create_new">Create New</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>index.php/tracker">Checkin Checkout</a>
                <ul>
                    <li><a href="<?php echo base_url(); ?>index.php/">Cheked in</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/">Checked out</a></li>
                </ul>
            </li>
        </ul>
    </nav>