<!doctype html>
<html lang="en">
<head>
    <title>DELETE ITEM :: <?php echo $this->options_model->get_option('company_name');?></title>
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
        div#body{padding:12px;}
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
        #form-success a, #form-error a{ margin-left:750px; }
        a#fold-back{margin-left:650px;}
        a.link-button{ padding:5px;background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; border:#999999 solid thin; }        
    </style>
    <link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">            
    <script type="text/javascript" language="javascript">
            
        $(document).ready(function(){

           $("a#link-button").click(function(){
                
              if(confirm("Are you sure you want to delete?")){
                    
                    var URL = "<?php echo base_url();?>index.php/items/confirm_delete/<?php echo $this->uri->segment(3);?>";

                    $.ajax({
                        url: URL,
                        cache: false,
                        type: "POST",
                        data: " ",
                        success: function(response) {
                            //alert(response);return false;
                            $("div#msg-box").html(response); 
                            $('a#fold-back').click(function(){
                                $('#form-success, #form-error').hide('slow');
                            });
                        }
                     });
                }
               return false;
           }); //end .submit()
           
        });//end document.ready()
            
    </script>
    
</head>
<body>

<div id="content_wrapper">
   
	<?php $this->load->view("common/header.php"); ?>
    
	<div id="body">
        <div id="msg-box"></div>
        
        <?php 
        if(isset($item)){?>
           <h2 style='color: #ff3333;'>You are about to delete <?php echo $item->description; ?></h2>
           <h2>Owner : <?php echo $person['unique_id']." (".$person['second_name']." ".$person['first_name'];?>)</h2>
           <?php if(isset($has_dependencies)){ ?>
           <h3>This item has system dependent data, can not be deleted. 
               <a href="<?php  echo base_url(). "index.php/items/edit_item/".$item->id; ?>">Edit</a>  instead.
           </h3>
           <?php }else{ ?>
           
                <h3><a class='link-button' id='link-button' href='#'>confirm</a> to proceed.</h3>
                <a href="<?php echo base_url()."index.php/items/edit_item/".$item['id']; ?>" class="link-button" id="link-button" >edit</a>
           <?php } ?>
     <?php
        }else{
            echo $error;
        }
        ?>
    </div>
    <div id="footer">
            <?php $this->load->view('common/footer.php'); ?>
    </div>

</div><!-- end wrapper //-->

</body>
</html>