<!doctype html>
<html lang="en">
<head>
    <title>EDIT PATRON:: <?php echo $this->options_model->get_option('company_name');?></title>
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
			     <?php $user_type = $this->session->userdata('user_type'); /*logged-in person*/?>   
				 <?php if($person['person_type']  !== 'admin' && $person['person_type'] !== 'staff'){/*person being viewed*/ ?>   
					$('#password').val('');
                    $('#password_r').val('');
                    $('#password').hide('slow');
                    $('#password_r').hide('slow');
				<?php } ?>
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
               
                    var URL = "<?php echo base_url();?>index.php/persons/save_edited_person/<?php echo $this->uri->segment(3);?>";
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
        <div style="text-align: center;"><h2 style="display:inline;">Edit Patron <?php echo $person['first_name']." ".$person['second_name'];?></h2></div>
        <div id="msg-box"></div>
        <form id="persons_form" method="post" action="#">
             <fieldset><legend>PERSONAL DETAILS</legend>
				<div id="avatar-area" align="center">
					<?php $avatar_img = $this->persons_model->get_avatar($person['id']);
					
						echo "Click to Edit<br>";
					?><a href="<?php echo base_url()."index.php/persons/upload_screen/".$this->uri->segment(3); ?>">
					<img src="<?php echo base_url()."images/avatars/". $avatar_img; ?>" width="235px" height="235px" border="0px"></a>
					<br />
					<?php echo $person['second_name'].", ".$person['first_name']; ?>
				</div>
                 <table>
                     <tr>
                         <td>First Name</td>
                         <td>
                             <input type="text" id="first_name" name="first_name" value="<?php 
                                if(isset($person['first_name'])){ echo $person['first_name'];} 
                               ?>">
                         </td>
                     </tr>
                     <tr><td>Second Name</td><td><input type="text" value="<?php echo $this->global_functions->html_sanitize( $person['second_name']); ?>" id="second_name" name="second_name"></td></tr>
                     <tr><td>PF/Reg. Number</td><td><input type="text"value="<?php echo $this->global_functions->html_sanitize( $person['unique_id']); ?>" id="unique_id" name="unique_id"></td></tr>
                     <tr><td>Email</td><td><input type="text" value="<?php echo $this->global_functions->html_sanitize( $person['email']); ?>" id="email" name="email"></td></tr>
                     <tr><td>Cellphone</td><td><input type="text" value="<?php echo $this->global_functions->html_sanitize( $person['cellphone']); ?>" id="cellphone" name="cellphone"></td></tr>
                     <tr>
                         <td>User type</td>
                         <td>
                             <select name="usertype" id="usertype">
								 <?php if($user_type == 'admin'){?>
								 <option value="<?php echo $person['person_type']; ?>"><?php echo $person['person_type'];?></option>
                                 <option value="admin">Admin</option>
								 <option value="staff">Staff</option>
								 <?php } ?>
								 <?php if($user_type == 'staff'){?>
								 <option value="<?php echo $person['person_type']; ?>"><?php echo $person['person_type'];?></option>
								 <option value="staff">Staff</option>
								 <?php } ?>
                                 <option value="patron">Patron</option>
                                 <option value="guest">Guest</option>
                             </select>
                         </td>
                     </tr>
                     <tr><td>password</td><td><input type="password" id="password" name="password"></td></tr>
                     <tr><td>password repeat</td><td><input type="password" id="password_r" name="password_r"></td></tr>
                     <tr><td>Address</td><td><textarea id="address" name="address"><?php  echo $person['address']; ?></textarea></td></tr>
                 </table>
                 <p>
                    <input type="submit" value="Edit person" /> &nbsp; &nbsp; 
                    <input type="reset" value="canel"> &nbsp; &nbsp; OR &nbsp; &nbsp;
                    <a href="<?php echo base_url()."index.php/persons/delete_person/".$person['id']; ?>" class="link-button" >delete</a>
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