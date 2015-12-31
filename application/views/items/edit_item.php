<!doctype html>
<html lang="en">
<head>
    <title>EDIT ITEM::<?php echo $this->options_model->get_option('company_name');?></title>
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
        a#fold-back{margin-left:650px;}
    </style>
	<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">                
    <script type="text/javascript" language="javascript">
            
        $(document).ready(function(){

           $("form#items_form").submit(function(){
                
                var form_vals = $("form#items_form").serialize(); 
                
                //$("div#msg-box").html(form_vals.replace(/'|%3E|%3C|%22/gi, "")); return false;
                
                var URL = "<?php echo base_url();?>index.php/items/save_edited_item/<?php echo $this->uri->segment(3);?>";
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
        <div style="text-align: center;"><h2 style="display:inline;">Edit Item <?php echo $item['unique_id'];?></h2></div>
        <div id="msg-box"></div>
        <form id="items_form" method="post" action="#">
             <fieldset><legend>ITEM DETAILS</legend>
                 <table>
                     <tr>
                         <td>Item ID</td>
                         <td>
                             <input type="text" id="unique_id" name="unique_id" value="<?php if(isset($item['unique_id'])){ echo $item['unique_id'];} ?>">
                         </td>
                     </tr>
                     <tr><td>Description</td><td><input type="text" value="<?php if(isset($item['description'])){ echo $item['description'];} ?>" id="description" name="description"></td></tr>
                     <tr><td>Owners ID</td><td><input type="text" value="<?php  echo $person['unique_id']; ?>" id="owner_id" name="owner_id"></td></tr>
                 </table>
                 <p>
                    <input type="submit" value="edit item" /> &nbsp; &nbsp; 
                    <input value="cancel" type="reset" value="cancel"> &nbsp; &nbsp; OR &nbsp; &nbsp;
                    <a href="<?php echo base_url()."index.php/items/delete_item/".$item['id']; ?>" class="link-button" id="link-button" >delete</a>
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