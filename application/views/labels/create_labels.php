<!doctype html>
<html lang="en">
<head>
    <title>BARCODES:: <?php echo $this->options_model->get_option('company_name');?></title>
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
        div#clear{ clear:both; }

        div#top-header{height:100px; 
                          min-width:800px;
                          
                          top:0px; position:absolute;
                          background: #efefef;
                          box-shadow: 0 0 5px black;
                          margin:0 auto 15 auto;
        }
	div#bc_form_wrapper{background:#999999; margin:5px; padding:5px;}
        div#bc_image{padding:5px; background:#cccccc; display:inline-block; margin:3px; height:75px; float:left;}
        div#bc_image img{}
        div#footer span{ text-align:center; }
        div#error-msg{background: #ffcccc; border: solid 1px #ff6666; padding: 5px; margin: 5px;}
        /*--------------------------------------------*/
@media print {
    body{margin:0px; padding:auto;}
    nav{display:none;}
    div#first_child{ display:none; }
    #log-details, #bc_form_wrapper,#top-header, #footer{display:none;}
    div#bc_image{padding:5px; background:#cccccc; display:inline-block; margin:3px; height:75px; float:left;}
    div#content_wrapper{width: 100%; 
                        margin: 15px; 
                        background: #ffffff; 
                        box-shadow: 0 0 0 #ffffff; margin-top:130px;}
    #pagination_form select, #pagination_form input{ display:none;}

}        
    </style>
<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">        
    <script type="text/javascript" language="javascript">
        $(document).ready(function(){
            $( document ).tooltip();
            $("#bc_width").val("80");
            $("#bc_height").val("50");
           
           $("form#bc_form").submit(function(){
               
               var symbology;
               
               var bcVal     = $.trim($("#bc_val").val());
               
               var bcWidth   = $.trim($("#bc_width").val());

               var bcHeight  = $.trim($("#bc_height").val());
               
               if(bcVal === ""){
                   $("div#msg-box").html("<div id='error-msg'>You must provide a value for the barcode !</div>");
                   return false;
               }
               if(bcWidth === ""){
                   $("#bc_width").val("80");
               }
               if(bcHeight === ""){
                   $("#bc_height").val("50");
               }
               
               var vals = $("form#bc_form").serialize();
               
               var URL = "<?php echo base_url(); ?>index.php/labels/create_label/?"+vals;

               var bcImage = "<img src='" + URL + "' />";
               $("div#first_content").html('');
               var bcWrapper = document.getElementById("sec_content");

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/labels/owners_name",
                    cache: false,
                    type: "POST",
                    data: vals,
                    success: function(response) {
                        bcImage = response+"<br />"+bcImage;
                        bcImage = "<div contenteditable='true'><div id='bc_image'>"+bcImage+"</div></div>";

                        $("div#sec_content").html(bcWrapper.innerHTML+bcImage);
                    }
                });		
            return false;
           }); 
           //===================================printer===============================
           $('input#print-labels').click(function(){
                window.print();
           });
        });//end document.ready()
            
    </script>
    
</head>
<body>
<div id="content_wrapper">
   
   <?php $this->load->view("common/header.php"); ?>
   
   <div id="body"><div id="first_child" style="text-align: center;"><h2 style="display:inline;">Generate Barcodes</h2></div>
                <div id="msg-box"></div>
        <form id="bc_form">
         <div id="bc_form_wrapper">
                <table>
                    <thead>
                    <tr>
                        <td><label for="symbology">symbology</label></td>
                        <td><label for="width">width</label></td>
                        <td><label for="height">height</label></td>
                        <td style="background:whitesmoke; margin-left:35px;"><label for="bc_value">Barcode value(Item ID)</label></td>
                        <td><label for="height"> &nbsp; </label></td>
                    </tr>
                    </thead>
                    <tr>
                        <td>
                             <select id="select_list" name="symbology">
                                 <option value="code128">Code 128</option>
                                <option value="code25">Code 25</option>
                                <option value="code39">Code 39</option>
                                <option value="ean2">EAN 2</option>
                                <option value="ean5">EAN 5</option>
                                <option value="ean8">EAN 8</option>
                                <option value="ean13">EAN 13</option>
                                <option value="identcode">Ident code</option>
                                <option value="leitcode">leit code</option>
                                <option value="planet">Planet</option>
                                <option value="postnet">Postnet</option>
                                <option value="royalmail">Royal mail</option>
                                <option value="upca">UPCA</option>
                                <option value="upce">UPCE</option>
                             </select>
                        </td>
                        <td>
                            <input type="text" name="bc_width" id="bc_width" size="7" title="Width of barcode to generate.">
                        </td>
                        <td>
                            <input type="text" name="bc_height" id="bc_height" size="7" title="Height of barcode to generate">
                        </td>
                        <td>    
                            <input type="text" name="bc_value" id="bc_val" size="15" title="Barcode number"> <input type="submit" value="generate">   
                        </td>
                        <td>    
                            <input type="button" value="print labels" id="print-labels">   
                        </td>
                    </tr>
                
                </table> 
            </div>
        </form> 
            <div id="bc_wrapper" style="">
                <div id="first_content">
                    <ul style="list-style-type:url('<?php echo base_url();?>images/arrow.gif');">
                        <label><strong>TO GENERATE BARCODES.......</strong></label>
                        <li>Select a symbology</li>
                        <li>Enter a value into the "barcode value" field</li>
                        <li>Click on generate or hit enter/return</li>
                        <li>Wait a SEC.</li>
                        <li>Click on barcode to copy/cut or delete or adjust dimensions</li>
                        <li>HAVE FUN !</li>
                    </ul>
                </div>
            </div><div id="sec_content"></div>
            
            <div id="clear"> <p> &nbsp; </p> </div>
       </div>
    <div id="footer">
            <span>You'r using Trakka Ver. 1.0 <br/>
            By <a href="http://libandweb.com" target="_blank"> synTACTIC </a>
            <br/>&COPY; Copyright  Mar. 2013.
            </span>
    </div>

</div><!-- end wrapper //-->

</body>
</html>