<!doctype html>
<html lang="en">
<head>
    <title>SET OPTIONS:: <?php echo $this->options_model->get_option('company_name');?></title>
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
        table thead{}
        table thead th{padding:4px;}
        table tbody tr{ }
        table tbody tr td{padding:4px;}
        div#footer{ background-repeat: repeat-x; 
                    height:55px; 
                    background: url("<?php echo base_url(); ?>images/glass.png");  
                    padding:10px;
                    text-align:center;
        }
        div#footer span{ text-align:center; }
        a.link-button{ padding:5px;background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; border:#999999 solid thin; }
        div#clear{ clear:both; }

        div#top-header{height:100px; 
			min-width:800px;

			top:0px; position:absolute;
			background: #efefef;
			box-shadow: 0 0 5px black;
			margin:0 auto 15 auto;
        }
		fieldset{margin:5px; padding:5px;}
        input, select{ background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; border:#999999 solid thin; padding:2px; }
		div#form-error{border:#ff0066 solid 1px; background:#ffcccc; margin:4px; padding-left:13px;}
        div#form-success{border:#00cc66 solid 1px; background:#ccffcc; margin:4px; padding-left:13px;}
        
	</style>
	<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">        
    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
			//alert('');
			$("form#options_form").submit(function(){
               var form_vals = $("form#options_form").serialize();
               
                    var URL = "<?php echo base_url();?>index.php/options/update_options";
                    $.ajax({
                        url: URL,
                        cache: false,
                        type: "POST",
                        data: form_vals.replace(/'|%3E|%3C|%22/gi, ""),
                        success: function(response) {
                            $("div#msg-box").html(response); 
                            $('a#fold-back').click(function(){
                                $('#form-success, #form-error').hide('slow');
                            });     
                        }
                     });
                
               return false;
           }); //end .submit()
		});
            
    </script>
    
</head>
<body>
<div id="content_wrapper">
   
   <?php $this->load->view("common/header.php"); ?>
   
    <div id="body">
		<div style="text-align: center;">
			<h2 style="display:inline;">Set System-wide Configurations</h2>
		</div>
		<div id="msg-box"></div>
		<div>
			<form id="options_form" method="post" action="#">
             <fieldset><legend>SYSTEM OPTIONS</legend>
                 <table>
                     <tr><td>Company name</td><td><input type="text" id="company_name" name="company_name" value="<?php echo $company_name; ?>"></td></tr>
                     <tr><td>Location</td><td><input type="text" value="<?php echo $location; ?>" id="location" name="location"></td></tr>
                     <tr><td>Address</td><td><input type="text" value="<?php echo $address; ?>" id="address" name="address"></td></tr>
                     <tr><td>Email</td><td><input type="text" value="<?php echo $email; ?>" id="email" name="email"></td></tr>
                     <tr><td>Cellphone</td><td><input type="text" value="<?php echo $cellphone; ?>" id="cellphone" name="cellphone"></td></tr>
                 </table>
                 <p>
                    <input type="submit" value=" Save " /> &nbsp; &nbsp; 
                    <input type="reset" value="cancel"> &nbsp; &nbsp; 
                 </p>
             </fieldset>
        </form>
		</div>
    </div>
    <div id="footer">
            <?php echo $this->load->view('common/footer.php'); ?>
    </div>

</div><!-- end wrapper //-->

</body>
</html>