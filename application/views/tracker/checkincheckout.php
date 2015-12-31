
<!doctype html>
<html lang="en">
<head>
    <title>CHECKIN-CHECKOUT:: <?php echo $this->options_model->get_option('company_name');?></title>
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
       
        div#content_wrapper{max-width: 800px; 
                            margin: auto; 
                            background: #efefef;  
                            box-shadow: 0 0 5px black; margin-top:130px;
                            border-radius: 0px;
        }
        table thead{background:#ddd;}
        table thead th{padding:4px;}
        table tbody tr{ background:#eee; }
        table tbody tr:hover{ background:#efefef; }
        table tbody tr td{padding:4px;}
        div#footer{ background-repeat: repeat-x; 
                    height:55px; 
                    background: url("<?php echo base_url(); ?>images/glass.png");  
                    padding:7px;
                    text-align:center;
        }
        div#footer span{ text-align:center; }
        a.link-button{ padding:5px;background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; border:#999999 solid thin; }
        form#checkin_form, form#checkout_form{padding:7px; background:#ccc;}
        div#top-header{height:100px; 
                          min-width:800px;
                          
                          top:0px; position:absolute;
                          background: #efefef;
                          box-shadow: 0 0 5px black;
                          margin:0 auto 15 auto;
        }
		div#avatar-area{
			float: right; display:inline;
			background: #ddd;
			height:290px;
			width:250px;padding:7px;
		}
		div#avatar-area img{margin:6px;}
    </style>
	<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">        
    <script type="text/javascript" language="javascript">

        $(document).ready(function(){
			
			$('input#item_unique_id').focus();
			
            $("form#search_form").submit( function () { 
				
                var URL  = "<?php echo base_url(); ?>index.php/tracker/get_item_details/";
                var data = $('form#search_form').serialize();
                $.ajax({
                    url    : URL,
                    cache  : false,
                    type   : "POST",
                    data   : data,
                    success: function(response) {
                        
                        $('#tbl-holder').html(response);
                        
                    }//end success 1
                }); 
            return false;
            });
            
            
        });//end document.ready()
            
    </script>
    
</head>
<body>
 <div id="content_wrapper">
 
 <?php $this->load->view("common/header.php"); ?>
 
 <div id="body">
       <div style="text-align: center;"><h2 style="display:inline;">CheckInCheckOut Items</h2></div>
        <div id="msg-box"></div>
        <div style="padding:5px; background:#ccc; margin:4px;">
            <form id="search_form" method="post">
                Enter item ID &nbsp; <input type="text" name="item_unique_id" id="item_unique_id" size="60" />
                <input type="submit" value="submit">
            </form>
            
        </div>
        <div id="tbl-holder" style="padding:5px;">
            <h3>No Item selected</h3>
        </div><!--end tbl-holder //-->
        
    </div>
    <div id="footer">
            <?php $this->load->view('common/footer.php'); ?>
    </div>

</div><!-- end wrapper //-->
</body>
</html>