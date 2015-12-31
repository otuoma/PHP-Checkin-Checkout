<!doctype html>
<html lang="en">
<head>
    <title>PATRON REPORTS:: <?php echo $this->options_model->get_option('company_name');?></title>
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
        tbody tr:hover{ background:#ffcccc;}
        div#top-header{height:100px; 
                          min-width:800px;
                          
                          top:0px; position:absolute;
                          background: #efefef;
                          box-shadow: 0 0 5px black;
                          margin:0 auto 15 auto;
        }
        /*#printBtns{background: #ff99cc ; border: #ff6666 solid 1px; padding: 5px;}*/
@media print {
    nav{display:none;}
    #log-details{ display:none;}
    #fetch_form{display:none;}
    #printBtns{display:none;}
    div#content_wrapper{width: 100%; 
                        margin: 15px; 
                        background: #ffffff; 
                        box-shadow: 0 0 0 #ffffff; margin-top:130px;}
    div#top-header{height:100px; 
                          width:100%;
                          top:0px; position:absolute;
                          background: #ffffff;
                          box-shadow: 0 0 5px #ffffff;
                          margin:0 auto 15 auto; }
/*    #footer{margin-top:15px; border-top:solid 1px black; padding-top:10px; }*/
#footer{display:none;}
    #footer a{ color:#003333;}
    #pagination_form select, #pagination_form input{ display:none;}

}
    </style>
	<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">        
    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
           $( "#dateone" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true,changeYear: true });
           $( "#datetwo" ).datepicker({ dateFormat: "yy-mm-dd", changeMonth: true,changeYear: true });
           
           $('#fetch_form').submit(function(){
		   
               var formVals = $('#fetch_form').serialize();
               var URL 		= "<?php echo base_url(); ?>index.php/persons/process_report";

               $.ajax({
                   url: URL,
                   cache: false,
                   type: "POST",
                   data: formVals,
                   success: function(response) {
				   //alert(response); return false;
                       $('#tbl-holder').html(response);
                   }
               });
            
            return false;
           });
        });//end document.ready()
            
    </script>
    
</head>
<body>
<div id="content_wrapper">
    
	<?php $this->load->view("common/header.php"); ?>
	
    <div id="body"><div style="text-align: center;"><h2 style="display:inline;">Registered Patrons Reports</h2></div>
        <div id="msg-box"></div>
        <div style="padding:5px; background:#ccc; margin:4px;">
            <form id="fetch_form" method="post" action="#">
                Per page <input type="text" name="perpage" id="perpage" value="15" size="12">
                Between <input type="text" name="dateone" id="dateone" size="12">
                and <input type="text" id="datetwo" name="datetwo" size="12">
                &nbsp; &nbsp; <input type="submit" id="fetch-btn" value="fetch" />
                
            </form>
            
        </div>
        <div id="tbl-holder" style="padding:5px;">
            <h3>Use the form above to generate a report</h3>
        </div><!--end tbl-holder //-->
        
    </div>
    <div id="footer">
            <?php $this->load->view('common/footer.php'); ?>
    </div>

</div><!-- end wrapper //-->

</body>
</html>