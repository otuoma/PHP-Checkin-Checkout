<!doctype html>
<html lang="en">
<head>
    <title>EDIT PATRON:: <?php echo $this->options_model->get_option('company_name');?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url(); ?>css/jquery-ui-1.9.2.custom.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>js/jquery/jquery-1.8.3.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery/jquery-ui-1.9.2.custom.js"></script>
	<script src="<?php echo base_url(); ?>js/plupload/plupload.full.min.js"></script>
    
    <style type="text/css">
        body{ background:#ffffff; 
              font-family: sans-serif; 
              font-size: 10pt;
              /*box-shadow: 9 0 5px black;*/
              margin: 0px;
              background-image:url(<?php echo base_url(); ?>images/windowfrost.png);  }
		#body{padding:5px;}
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
        div#form-success{border:#00cc66 solid 1px; background:#ccffcc; margin:4px; padding:8px; padding-left:15px;}
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
		#upload-input{
			padding:8px;background:#ddd;
		}
		div#avatar-area{
			float: right; display:inline;
			background: #ddd;
			height:270px;
			width:250px;padding:7px;
		}
		div#avatar-area img{margin:6px;}
		progress{display:none;}
		
    </style>
	<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">        
    <script type="text/javascript" language="javascript">
            
        $(document).ready(function(){
		
		function progressHandlingFunction(e){
			if(e.lengthComputable){
				$('progress').attr({value:e.loaded,max:e.total});
			}
		}
		
	    $(':button').click(function(){
				$('div#msg-box').html('Please wait ......');
				var URL = "<?php echo base_url();?>index.php/persons/upload_avatar/<?php echo $this->uri->segment(3);?>";
				
				var formData = new FormData($('form')[0]);
				
				$.ajax({
					url: URL,
					type: 'POST',
					success: function(response){
						$('div#msg-box').html(response);
						$.ajax({
							url: '<?php echo base_url()."index.php/persons/get_avatar_src/".$person['id'];?>',
							type: 'POST',
							data:"",
							success: function(respons){$('img#avatar-img').attr('src', respons);}
						});
						
					},
					error: function(err){ alert('fail'); return false; },
					// Form data
					data: formData,
					//Options to tell jQuery not to process data or worry about content-type.
					cache: false,
					contentType: false,
					processData: false
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
		<?php if(isset($person)){ ?>
			
			<div style="text-align: center;">
				<h2 style="display:inline;">Upload new photo for <?php echo $person['first_name']." ".$person['second_name']; ?></h2>
			</div>
       
			<div id="msg-box"></div>
			
			<div id="form-holder">
				
				<form enctype="multipart/form-data" style="padding:8px; margin-bottom:5px;margin-top:15px; background:#ddd;">
					<input name="file" type="file" />
					<input type="button" value="Upload" />
				</form>
				<div  style="float:left;display:inline; margin:15px;">
					<h3>Recommended image properties</h3>
					<ol>
						<li>Height :250 pixels
						<li>Width :250 pixels
						<li>Size : Not greater than 5 MB
						<li>Formats : PNG, JPG, JPEG, GIF, BMP, DIB
					</ol>
					<p>&nbsp;</p>
					<h3>View <?php echo "<a href='".base_url()."/index.php/persons/edit_person/".$person['id']."'>".$person['first_name']." ".$person['second_name']; ?>'s details</a>.</h3>
				</div>
				<div id="avatar-area" align="center">
				<?php $avatar_img = $this->persons_model->get_avatar($person['id']);?>
				<a href="<?php echo base_url()."index.php/persons/upload_screen/".$this->uri->segment(3); ?>">
				<img id="avatar-img" src="<?php echo base_url()."images/avatars/". $avatar_img; ?>" width="235px" height="235px" border="0px"></a>
				<br />
				<?php echo $person['second_name'].", ".$person['first_name']; ?>
				</div>
				<p style="clear:both;"> &nbsp; </p>
			</div>

	   <?php }else{//persons details not set
	   
			echo "<h2>Persons details not set</h2>";
	   
	   } ?>
    </div>
    <div id="footer">
            <?php $this->load->view('common/footer.php'); ?>
    </div>

</div><!-- end wrapper //-->

</body>
</html>