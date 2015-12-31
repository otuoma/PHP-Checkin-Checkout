<!doctype html>
<html lang="en">
<head>
    <title>ALL ITEMS :: <?php echo $this->options_model->get_option('company_name');?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url(); ?>css/jquery-ui-1.9.2.custom.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>js/jquery/jquery-1.8.3.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery/jquery-ui-1.9.2.custom.js"></script>
    <style type="text/css">
        body{ background:#ffffff; 
              font-family: sans-serif; 
              font-size: 10pt;
              /*box-shadow: 9 0 5px black;*/
              margin: 0px;
              background-image:url(<?php echo base_url(); ?>images/windowfrost.png);  }
        a{text-decoration:none; 
          color:#0000ff;}
        div#global_header{height:100px;
                          position: fixed; 
                          width:100%;
                          top:0px;
                          /*background:#FFFFFF; */
                          box-shadow: 0 0 5px black;
                          margin: 0px  0px 15px 0px;
        }
        div#global_header h1{display: inline; margin-left:200px;}
        div#global_header img{margin-left: 50px; margin-top:15px;}
        div#content_wrapper{max-width: 800px; 
                            margin: auto; 
                            background:whitesmoke; 
                            box-shadow: 0 0 5px black; margin-top:130px;}
        table thead{background:#ddd;}
        table thead th{padding:4px;}
        table tbody tr{ background:#eee; }
        table tbody tr td{padding:4px;}
        div#footer{ background-repeat: repeat-x; 
                    height:55px; 
                    background: url("<?php echo base_url(); ?>images/glass.png");  
                    padding:10px;
                    text-align:center;
        }
        div#footer span{ text-align:center; }
        a.link-button{ padding:5px;background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; border:#999999 solid thin; }
        tbody tr:hover{ background:#ffcccc;}
        
    </style>
	<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">
        
    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
            $("input#search_val").keyup(
                function () { 

                    var URL = "<?php echo base_url(); ?>index.php/items/livesearch/";

                    $.ajax({
                        url: URL,
                        cache: false,
                        type: "POST",
                        data: $('form#search_form').serialize(),
                        success: function(response) {
                            $('#tbl-holder').html(response);
                        }
                    });
                });
        });//end document.ready()
            
    </script>
    
</head>
<body>
<div id="content_wrapper">

    <?php $this->load->view("common/header.php"); ?>
	
    <div id="body"><div style="text-align: center;"><h2 style="display:inline;">View All Items</h2></div>
        <div id="msg-box"></div>
        <div style="padding:5px; background:#ccc; margin:4px;">
            <form id="search_form" method="post">
                Search Item ID &nbsp; <input type="text" name="search_val" id="search_val" size="50" autocomplete="off" />
            </form>
            
        </div>
        <div id="tbl-holder" style="padding:5px;">
        <?php if($items->num_rows() >0){ ?>
        
        <table id="results">
            <thead>
            <th>ITEM ID</th><th>Description</th><th>Location</th><th>Owner ID</th><th>Registered on</th><th>Delete</th>
            </thead>
            <tbody>
            <?php
            
            foreach ($items->result_array() as $item) {
                
                $person = $this->items_model->get_item_owner($item['owner_id']);
                
                    echo "<tr>
                            <td><a href=".  base_url()."index.php/items/edit_item/".$item['id']." title='click to edit'>
                            ".$item['unique_id']."</a></td>
                            <td>".$item['description']."</td>
                            <td>".$item['location']."</td>
                            <td>". $person['unique_id']."</td>
                            <td>". date('Y-m-d', strtotime($item['time']))."</td>
                            <td><a href='".base_url()."index.php/items/delete_item/".$item['id']."'>"."#"."</a></td>
                         </tr>";
                
            }
        ?></tbody></table><?php  }else{
            echo "<h3> No items were found on the database</h3>";
        } ?>
	<?php echo $pg_links; ?>
        </div><!--end tbl-holder //-->
        
    </div>
    <div id="footer">
            <?php $this->load->view('common/footer.php'); ?>
    </div>

</div><!-- end wrapper //-->

</body>
</html>