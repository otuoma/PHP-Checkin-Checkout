<!doctype html>
<html lang="en">
<head>
    <title>TRAKKA :: <?php echo $this->options_model->get_option('company_name');?></title>
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
      
        div#form-holder{
            width:380px;
            background:#ffffff;
            margin:auto;
            box-shadow: 0 0 5px black; margin-top:100px;
            padding:15px;
        }
        label{display:block;}
        form input{background: url("<?php echo base_url(); ?>images/input_bg.gif") fixed; 
                   border:#999999 solid  1px; 
                   height:20px;
                   padding:1px;
        }
        fieldset{padding:20px;}
        fieldset legend{font-weight:bold; font-size:20px;}
        fieldset form label{font-size:15px; font-weight:bold;}
        div#footer{text-align:center; margin:20px auto 10px auto;}
        
        
    </style>
        
    <script type="text/javascript" language="javascript">
         
        $(document).ready(function(){
            
            $('input#emailf').focus(function(){
                
                $('input#emailf').val('');
                
                $('input#emailf').focusout(function(){
                    if($.trim($('input#emailf').val()) == ""){
                        
                        $('input#emailf').val('Your email here');
                    
                    }
                });
            });
            
            $('form#login-form').submit(function(){
                var URL = "<?php echo base_url(); ?>index.php/login/patron_login";
                var formVals = $('form#login-form').serialize();
                $.ajax({
                    url: URL,
                    cache: false,
                    type: "POST",
                    data: formVals.replace(/'|%3E|%3C|%22/gi, ""),
                    success: function(response) {
                        $('div#msg-box').html(response);

                        var referer = "<?php echo $referer; ?>";

                        if (document.cookie.indexOf("logged_in") >= 0) {
                            setTimeout(function(){ 
                                window.location = referer; 
                            }, 2000);                            
                        }

                    }
                });
                
                return false;
            });
           
        });//end document.ready()
            
    </script>
    
</head>
<body>

<div id="content_wrapper">
    
    <div id="form-holder">
        <img src="<?php echo base_url(); ?>/images/login-header.png">
        <div id="msg-box"> 
            <?php if(isset($logged_out)){ echo $logged_out; }?>
            <?php if(isset($login_info)){ echo $login_info; }?>
        </div>
        <fieldset>
            <legend>LOGIN</legend>
            <form method="post" action="#" id="login-form">
                <label>User name</label>
                <input type="text" id="emailf" name="emailf" size="40" value="Your email here">
                
                <p></p>
                <label>Password</label>
                <input type="password" id="passwordf" name="passwordf" size="40">
                <p></p>
                <input type="submit" value="login" id="submitBtn">
                
            </form>
        </fieldset>
        <div id="footer">
            <span>Powered by PHP checkin-Checkout 1.0 <br/>
        From <a href="http://syntactic.co.ke" target="_blank"> synTACTIC.co.ke </a>
        <br/>&copy; Copyright 2013.
        </span>
    </div>
    </div>
    
    

</div><!-- end wrapper //-->

</body>
</html>