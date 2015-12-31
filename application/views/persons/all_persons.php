<!doctype html>
<html lang="en">
<head>
    <title>ALL PATRONS:: <?php echo $this->options_model->get_option('company_name');?></title>
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
        div#ad_banner, div#menu-box, div#footer{ background-repeat: repeat-x; 
                    height:55px; 
                    background: url("<?php echo base_url(); ?>images/glass.png");  
                    padding:10px;
                    text-align:center;
        }
        tbody tr:hover{ background:#ffcccc;}
        div#tbl-holder{ padding:12px;}
        div#footer span{ text-align:center; }
        a.link-button{ padding:5px;background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; border:#999999 solid thin; }
    </style>
	<link href="<?php echo base_url(); ?>css/main-menu.css" rel="stylesheet">        
    <script type="text/javascript" language="javascript">
            
        $(document).ready(function(){
            $("input#search_val").keyup(
                function () { 

                    var URL = "<?php echo base_url(); ?>index.php/persons/livesearch/";

                    $.ajax({
                        url: URL,
                        cache: false,
                        type: "POST",
                        data: $('form#search_form').serialize(),
                        success: function(response) {
                            $('#tbl-holder').html(response);
//                            $("table#results").html().hide('slow');
//                            $("table#results").html(response);
                        }
                    });
                });
        });//end document.ready()
            
    </script>
    
</head>
<body>

<div id="content_wrapper">
    
	<?php $this->load->view("common/header.php"); ?>
    
	<div id="body">
        <div style="text-align: center;"><h2 style="display:inline;">View all Patrons</h2></div>
        <div id="msg-box"></div>
        <div style="padding:5px; background:#ccc; margin:4px;">
            <form id="search_form" method="post">
                Search patron ID &nbsp; <input type="text" name="search_val" id="search_val" size="50" autocomplete="off" />
            </form>
            
        </div>
        <div id="tbl-holder">
        <?php if($persons->num_rows() >0){ ?>
        
            <table id="results">
                <thead>
                    <th>Edit</th><th>Email</th><th>PF/Reg. Number</th><th>Cellphone</th><th>Date</th><th>Delete</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($persons->result_array() as $person) {
						
						echo "<tr>
							<td><a href=".  base_url()."index.php/persons/edit_person/".$person['id']." title='click to edit'>
								".$this->global_functions->html_sanitize( $person['first_name'])." &nbsp; ".$this->global_functions->html_sanitize( $person['second_name'])."</a></td>
							<td>".$person['email']."</td>
							<td>".$this->global_functions->html_sanitize( $person['unique_id'])."</td>
							<td>".$this->global_functions->html_sanitize( $person['cellphone'])."</td>
							<td>".$person['time']."</td>
							<td><a href='".base_url()."index.php/persons/delete_person/".$person['id']."'>"."#"."</a></td>
						 </tr>";
						
						//if($person['id'] == $this->session->userdata('staff_id')){continue;}
                        
						
                    }
                    ?>
                </tbody>
            </table>
            <?php  }else{

                    echo '<h3>No ,persons were found on the database; </h3>';        
                }
            ?>
            <?php echo $pg_links; ?>
       </div> <!--end tbl-holder//>-->
        
        <div id="footer">
                 <?php $this->load->view('common/footer.php'); ?>
        </div>
    </div>

</div><!-- end wrapper //-->

</body>
</html>