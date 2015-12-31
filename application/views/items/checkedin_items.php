<!doctype html>
<html lang="en">
<head>
    <title>CHECKED-IN:: <?php echo $this->options_model->get_option('company_name');?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url(); ?>css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>js/jquery/jquery-1.8.3.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery/jquery-ui-1.9.2.custom.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery/jquery-ui-timepicker-addon.js"></script>
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
                          background:#ccc; 
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
       
    </style>
	<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">        
    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
            $( "#dateone" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true,changeYear: true });
            $( "#datetwo" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true,changeYear: true });
            $("input#item_unique_id").keyup(
                function () { 

                    var URL = "<?php echo base_url(); ?>index.php/items/checkedin_livesearch";

                    $.ajax({
                        url: URL,
                        cache: false,
                        type: "POST",
                        data: $('form#search_form').serialize(),
                        success: function(response) {
                            $('#tbl-holder').html(response);
//                                alert(response);
                        }
                    });
                });
        });//end document.ready()
            
    </script>
    
</head>
<body>
<div id="content_wrapper">

    <?php $this->load->view("common/header.php"); ?>

    <div id="body">
        <div style="text-align: center;"><h2 style="display:inline;">Checked in Items</h2></div>
        <div id="msg-box"></div>
        <div style="padding:5px; background:#ccc; margin:4px;">
            <form id="search_form" method="post" action="#">
                Between <input type="text" name="dateone" id="dateone" size="16">
                and <input type="text" id="datetwo" name="datetwo" size="16">
                &nbsp; &nbsp; Search Item ID &nbsp; <input type="text" name="item_unique_id" id="item_unique_id" size="40" autocomplete="off" />
                
            </form>
            
        </div>
        <div id="tbl-holder" style="padding:5px;">
        <?php if($items->num_rows() >0){ ?>
        
        <table id="results">
            <thead>
            <th>ITEM ID</th><th>Owners ID</th><th>Checked in by</th><th>DateTime</th>
            </thead>
            <tbody>
            <?php
            
            foreach ($items->result_array() as $item) {
                
                $item_detail = $this->persons_model->get_item_with_unique_id($item['item_unique_id']);
                $person_detail = $this->items_model->get_item_owner($item_detail->owner_id);
                
                    ?><tr>
                            <td><?php echo $item['item_unique_id']; ?></td>
                            <td><?php echo $person_detail['unique_id']; ?></td>
                            <td>
                                
                                <?php if($item['checkin_person_id'] !== $person_detail['unique_id']){
                                    echo "<span style='color:red;' title='item checked in by person who is not the registered owner'>";
                                }?>
								<?php echo $item['checkin_person_id']; ?>
								<?php if($item['checkin_person_id'] !== $person_detail['unique_id']){ echo "</span>"; }?>
                            </td>
                            <td><?php echo date('d-m-Y', strtotime($item['time'])); ?></td>
                         </tr>
                    <?php
                
            }
        ?></tbody></table><?php  }else{
            echo "<h3>No items were found on the database</h3>";
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