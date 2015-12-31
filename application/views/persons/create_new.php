<!doctype html>
<html lang="en">
<head>
    <title>CREATE PATRON:: <?php echo $this->options_model->get_option('company_name');?></title>
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
        div#ad_banner, div#menu-box, div#footer{ background-repeat: repeat-x; 
                    height:55px; 
                    background: url("<?php echo base_url(); ?>images/glass.png");  
                    padding:10px;
                    text-align:center;
        }
        fieldset{margin:5px; padding:5px;}
        input, select{ background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; border:#999999 solid thin; padding:2px; }
        div#form-error{border:#ff0066 solid 1px; background:#ffcccc; margin:4px; padding-left:13px;}
        div#form-success{border:#00cc66 solid 1px; background:#ccffcc; margin:4px; padding-left:13px;}
        div#footer span{ text-align:center; }
        #form-success a, #form-error a{ margin-left:650px; }
        a.link-button{ padding:5px;background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; border:#999999 solid thin; }
    </style>
	<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">        
    <script type="text/javascript" language="javascript">
            
        $(document).ready(function(){
        
           $("select#usertype").change(function() {
                var selectedOption = $("#usertype").val();
                if(selectedOption == "patron" || selectedOption == "guest"){
                    $('#password').val('');
                    $('#password_r').val('');
                    $('#password').hide('slow');
                    $('#password_r').hide('slow');
                }else{
                    $("#password").show('slow');
                    $('#password_r').show('slow')
                }
           });
           
           $("form#persons_form").submit(function(){
               var form_vals = $("form#persons_form").serialize(); 
	       
                    var URL = "<?php echo base_url();?>index.php/persons/save_new_person";
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
           
        });//end document.ready()
            
    </script>
    
</head>
<body>

<div id="content_wrapper">
 
 <?php $this->load->view("common/header.php"); ?>
 
 <div id="body">
        <div style="text-align: center;"><h2 style="display:inline;">Create New Patron</h2></div>
        <div id="msg-box"></div>
        <form id="persons_form" method="post" action="#">
             <fieldset><legend>PERSONAL DETAILS</legend>
                 <table>
                     <tr>
                         <td>First Name</td>
                         <td>
                             <?php echo form_error('first_name'); ?>
                             <input type="text" id="first_name" name="first_name" value="<?php echo set_value('first_name'); ?>">
                         </td>
                     </tr>
                     <tr><td>Second Name</td><td><input type="text" id="second_name" name="second_name"></td></tr>
                     <tr><td>Card number</td><td><input type="text" id="unique_id" name="unique_id"></td></tr>
                     <tr><td>Email</td><td><input type="text" id="email" name="email"></td></tr>
                     <tr><td>Cellphone</td><td><input type="text" id="cellphone" name="cellphone"></td></tr>
                     <tr>
                         <td>User type</td>
                         <td><?php //if($this->session->userdata('is_admin') == TRUE){echo "is admin";}else{echo "not admin";} ?>
                             <select name="usertype" id="usertype">
								<!--<option value=" "></option>//-->
                                <?php if($this->session->userdata('user_type') == 'admin'){?>
                                 <option value="admin">Admin</option>
								 <option value="staff">Staff</option>
								 <?php } ?>
								 <?php if($this->session->userdata('user_type') == 'staff'){?>
								 <option value="staff">Staff</option>
								 <?php } ?>
								 
								 <option value="patron">Patron</option>
                                 <option value="guest">Guest</option>
                             </select>
                         </td>
                     </tr>
                     <tr><td>password</td><td><input type="password" id="password" name="password"></td></tr>
                     <tr><td>password repeat</td><td><input type="password" id="password_r" name="password_r"></td></tr>
                     <tr><td>Address</td><td><textarea id="address" name="address"></textarea></td></tr>
                 </table>
                 <p>
                    <input type="submit" value="create person" /> &nbsp; &nbsp; <input type="reset" value="canel">
                 </p>
             </fieldset>
        </form>
    </div>
    <div id="footer">
             <?php $this->load->view('common/footer.php'); ?>
    </div>

</div><!-- end wrapper //-->

</body>
</html>