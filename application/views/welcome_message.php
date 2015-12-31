<!doctype html>
<html lang="en">
<head>
    <title>TRAKKA:: Kenyatta University Library</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="<?php echo base_url(); ?>css/jquery-ui-1.9.2.custom.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>js/jquery/jquery-1.8.3.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery/jquery-ui-1.9.2.custom.js"></script>
        
    <script type="text/javascript" language="javascript">

        $(document).ready(function(){
           
           $("form#").submit(function(){
               
            return false;
           }); 
           
        });
            
    </script>
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
        div#content_wrapper{max-width: 900px; 
                            margin: auto; 
                            background:whitesmoke; 
                            box-shadow: 0 0 5px black; margin-top:130px;}
        div#error-msg{background:#ff6699; border:#ccc solid 1px; padding:3px;}
        div#ad_banner, div#footer{ background-repeat: repeat-x; 
                    height:55px; 
                    background: url("<?php echo base_url(); ?>images/glass.png");  
                    padding:10px;
                    text-align:center;
        }
        fieldset{margin:5px; padding:5px;}
        input, select{ background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; border:#999999 solid thin; padding:2px; }
        div#footer span{ text-align:center; }
    </style>
    
</head>
<body>
 <div id="global_header">
     <img src="<?php echo base_url(); ?>images/logo-2.png" id="logo-img" width="150px;">
     <h1>KENYATTA UNIVERSITY LIBRARY</h1>
    </div>
<div id="content_wrapper">
   
    <div id="ad_banner">
        <h3>LIBRARY LAPTOP TRACKER</h3>
    </div>
    <div id="body">
        <div id="msg-box"></div>
       
        <fieldset><legend>TRACK ITEMS</legend>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/tracker">CheckinCheckout</a></li>
                <li><a href="<?php echo base_url(); ?>">Checked in</a></li>
                <li><a href="<?php echo base_url(); ?>">Checked out</a></li>
            </ul>

        </fieldset>
        <fieldset><legend>PERSONS</legend>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/persons">All persons</a></li>
                <li><a href="<?php echo base_url(); ?>index.php/persons/create_new">Create New</a></li>
            </ul>
        </fieldset>
        <fieldset><legend>ITEMS</legend>
            <ul>
                <li><a href="<?php echo base_url(); ?>index.php/items">All Items</a></li>
                <li><a href="<?php echo base_url(); ?>index.php/items/create_new">Create New</a></li>
            </ul>
        </fieldset>
    </div>
    <div id="footer">
            <?php $this->load->view('common/footer.php'); ?>
    </div>

</div><!-- end wrapper //-->

</body>
</html>