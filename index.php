<?php
if (!empty($_REQUEST['Sender'])):
    $sender = $_REQUEST['Sender'];
    $layout = file_get_contents('./layout.html', FILE_USE_INCLUDE_PATH);
    foreach ($sender as $key => $value) {
        $key = strtoupper($key);
        $start_if = strpos($layout, '[[IF-' . $key . ']]');
        $end_if = strpos($layout, '[[ENDIF-' . $key . ']]');
        $length = strlen('[[ENDIF-' . $key . ']]');

        if (!empty($value)) {
            // Add the value at its proper location.
            $layout = str_replace('[[IF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[ENDIF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[' . $key . ']]', $value, $layout);


        } elseif (is_numeric($start_if)) {
            // Remove the placeholder and brackets if there is an if-statement but no value.
            $layout = str_replace(substr($layout, $start_if, $end_if - $start_if + $length), '', $layout);
        } else {
            // Remove the placeholder if there is no value.
            $layout = str_replace('[[' . $key . ']]', '', $layout);
        }
    }

    // Clean up any leftover placeholders. This is useful for booleans,
    // which are not submitted if left unchecked.
    $layout = preg_replace("/\[\[IF-(.*?)\]\]([\s\S]*?)\[\[ENDIF-(.*?)\]\]/u", "", $layout);
// $layout2 = preg_replace("/\[\[IF-(.*?)\]\]([\s\S]*?)\[\[ENDIF-(.*?)\]\]/u", "", $layout2);
    if (!empty($_REQUEST['download'])) {
        header('Content-Description: File Transfer');
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename=signature.html');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }

    echo $layout;

else: ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <title>Signature Generator</title>

<!-- End Google Tag Manager -->
    <!-- Bootstrap core CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
   <link href="/css/bootstrap-colorpicker.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <style type="text/css">
        /* Sticky footer styles
        -------------------------------------------------- */
.main-header{
    color:#ff6b12;
}
        html,
        body {
            height: 100%;
            /* The html and body elements cannot have any padding or margin. */
        }
select{
    width: 100%;
}
        /* Wrapper for page content to push down footer */
        #wrap {
       /*     min-height: 100%;*/
            height: auto !important;
            height: 100%;
            /* Negative indent footer by its height */
            margin: 0 auto -60px;
            /* Pad bottom by footer height */
            padding: 0 0 60px;
        }
.page-header {
    padding-bottom: 0;
    margin: 0px 0 20px;
        /* Set the fixed height of the footer here */
        #footer {
            height: 60px;
            background-color: #f5f5f5;
        }

        /* Custom page CSS
        -------------------------------------------------- */
        /* Not required for template or sticky footer method. */

        #wrap > .container {
            padding: 20px 15px 0;
        }

        .container .credit {
            margin: 20px 0;
        }

        #footer > .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        code {
            font-size: 80%;
        }

        .navbar-default {
            background-color: #ffffff;

        }
    </style>

</head>

<body>

<!-- Wrap all page content here -->
<div id="wrap" class="pinnacle-wrapper">
    <!-- Fixed navbar -->

    <!-- Begin page content -->
    <div class="container">
        <div class="page-header">
            <h1 class="main-header">Email Signature generator</h1>
            
            <h2 class="main-header" style="font-size:16px">Free email signature generator tool</h2>
        </div>
        <form role="form" method="post" target="preview" id="form">
            <div class="row">
                <!-- Personal information -->
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                     <!--    <label for="Name">Full Name</label> -->
                        <input type="text" class="form-control" id="Name" name="Sender[name]"
                               placeholder="Enter your name">
                    </div>
  </div>

     <div class="col-sm-6 col-md-6">

                        <input type="hidden" class="form-control phone" id="emailepre"
                               name="Sender[email_pre]" placeholder="e" value="">

                    <div class="form-group">
                  <!--       <label for="Email">Email</label> -->
                        <input type="email" class="form-control" id="Email" name="Sender[email]"
                               placeholder="Enter your email">
                    </div>   </div>

          <div class="clearfix"></div>

   <div class="col-sm-3 col-md-3">
      <div class="form-group">

                <!--         <label for="Logo"> Company LOGO URL </label>
 -->                        <input type="text" class="form-control" id="companyname"
                               name="Sender[companyname]" placeholder="Company Name" value="">
                  </div>
     </div>

   <div class="col-sm-3 col-md-3">
      <div class="form-group">

                <!--         <label for="Logo"> Company LOGO URL </label>
 -->                        <input type="text" class="form-control logo" id="logo"
                               name="Sender[logo]" placeholder="insert URL to your logo file" value="">
                  </div>
     </div>
         <div class="col-sm-3 col-md-3">
    <div class="form-group">
               <!--          <label for="Web"> Website URL ( Include HTTP/HTTPS ) </label> -->
                        <input type="text" class="form-control" id="web" name="Sender[web]"
                               placeholder="Website URL ( Include HTTP/HTTPS )" value="">
                    </div>
         </div>



             <div class="col-sm-3 col-md-3">
       <input type="hidden" class="form-control phone" id="webpre"
                               name="Sender[web_pre]" placeholder="w" value="">
                    <div class="form-group">
          <!--               <label for="Webshow"> Website Display Name </label> -->
                        <input type="text" class="form-control" id="webshow" name="Sender[webshow]"
                               placeholder="Website Display Name - thiswebsite.com" value="">
                    </div>
         </div>

  <div class="col-sm-3 col-md-3">

   

                                <div class="form-group">
                 <!--        <label for="position"> Job title </label> -->
                        <input type="text" class="form-control" id="position" name="Sender[position]" placeholder="Enter your job title"
                               value="">
                    </div>
   </div>
       
           <div class="col-sm-3 col-md-3">
<div class="form-group">
        <!--                 <label for="department"> Department</label> -->
                        <input type="text" class="form-control" id="department" name="Sender[department]"
                               placeholder="Enter your team name" value="">
                    </div>
           </div>

                 <div class="col-sm-3 col-md-3">
    
      <div class="form-group">
                  
                        <input type="hidden" class="form-control phone" id="phonepre"
                               name="Sender[phone_pre]" placeholder="p" value="">
       
                 <!--        <label for="Phone"> Phone </label> -->
                        <input type="phone" class="form-control phone" id="companyPhone"
                               name="Sender[company_phone]" placeholder="Enter your phone number" value="">
                    </div>
                 </div>


                       <div class="col-sm-3 col-md-3">
      <input type="hidden" class="form-control phone" id="mobileepre"
                               name="Sender[mobile_pre]" placeholder="m" value="">
                  
                    <div class="form-group">
          <!--               <label for="Phone">Mobile Number</label> -->
                        <input type="phone" class="form-control phone" id="personalPhone" name="Sender[phone]"
                               placeholder="Enter your Mobile number">
                    </div>
                 </div>
  
            

                <div class="clearfix"></div>
         
         
                <div class="col-md-12 text-left">

                    <!-- ADDRESS INFORMATION -->
                        <div class="page-header">
            <h3 class="main-header">Address</h2>
        </div>
            <input type="hidden" class="form-control phone" id="addressepre"
                               name="Sender[address_pre]" placeholder="a" value="">
          <div class="col-sm-6 col-md-6">
                    <div class="form-group">
               <!--          <label for="Street"> Street Address </label> -->
                        <input type="text" class="form-control" id="street" name="Sender[street]"
                               placeholder="Addres line" value="">
                    </div>       </div>
          <div class="col-sm-6 col-md-6">
                    <div class="form-group">
   <!--                      <label for="City"> Address line 2 </label> -->
                        <input type="text" class="form-control" id="city" name="Sender[city]"
                               placeholder="Addres line 2" value="">
                    </div>       </div>
      
    <div class="clearfix"></div>
         
         
                                <div class="page-header">
            <h3 class="main-header">Social Media</h2>
        </div>
    <div class="form-group">      <div class="col-sm-12 col-md-12">
<input type="checkbox" name="Sender[check0]" value="none">&nbsp;Hide Social media row<br></div></div>
          <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                   <!--      <label for="fb"> Facebook</label> -->
                        <input type="text" class="form-control" id="fb" name="Sender[fb]" placeholder="insert URL to your Facebook" value=""> <input type="checkbox" name="Sender[check1]" value="none">&nbsp;Hide
                    </div>
     </div>
              <div class="col-sm-4 col-md-4">
                    <div class="form-group">
             <!--            <label for="tw">Twitter</label> -->
                        <input type="text" class="form-control" id="tw" name="Sender[tw]" placeholder="insert URL to your Twitter" value=""><input type="checkbox" name="Sender[check2]" value="none">&nbsp;Hide
                    </div>
      </div>
                  <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                <!--         <label for="ig">Instagram</label> -->
                        <input type="text" class="form-control" id="ig" name="Sender[ig]" placeholder="insert URL to your Instagram" value=""><input type="checkbox" name="Sender[check3]" value="none">&nbsp;Hide
                    </div>
                          </div>
    <div class="col-sm-4 col-md-4">
             
                    <div class="form-group">
               <!--          <label for="li">LinkedIn</label> -->
                        <input type="text" class="form-control" id="li" name="Sender[li]" placeholder="insert URL to your LinkedIn" value=""><input type="checkbox" name="Sender[check4]" value="none">&nbsp;Hide
                    </div>
      </div>
    <div class="col-sm-4 col-md-4">
                    <div class="form-group">
             <!--            <label for="gp">Pinterest</label> -->
                        <input type="text" class="form-control" id="gp" name="Sender[gp]" placeholder="insert URL to your Pinterest" value=""><input type="checkbox" name="Sender[check5]" value="none">&nbsp;Hide
                    </div>
                          </div>
                </div>
          <div class="clearfix"></div>
       
        <div class="col-md-12">
                           
                        <div class="page-header">
            <h3 class="main-header">Disclaimer</h2>
       </div>
                    <div class="form-group">
               
                        <input type="text" class="form-control" id="disclaimerid" name="Sender[disclaimer]" placeholder="Insert your disclaimer" value="">
                    </div>
 



         <div class="clearfix"></div>


                           
                        <div class="page-header">
            <h3 class="main-header">Style</h2>
</div>
                <div class="col-sm-3 col-md-3">

                
                     <label for="Color"> Color </label>


                    <div id="cp2" class="input-group colorpicker-component">
    <input type="text" value="#00AABB" class="form-control" name="Sender[fontcolor]"/>
    <span class="input-group-addon"><i></i></span>
</div>

                

                </div>

                     <div class="col-sm-3 col-md-3">
  <label for="font">Font</label><br>

                        <select name="Sender[font]">
  <option value="arial">arial</option>
  <option value="calibri">calibri</option>
  <option value="sans-serif">sans-serif</option>
  <option value="Trebuchet MS">Trebuchet MS</option>
</select>
                     </div>


                                   <div class="col-sm-3 col-md-3">
  <label for="font">Name Font Size</label><br>

                        <select name="Sender[namefontsize]">
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
   <option value="17">17</option>
  <option value="18" selected>18</option>
</select>
                     </div>


                                  <div class="col-sm-3 col-md-3">
  <label for="font">Rest of the Font Size</label><br>

                        <select name="Sender[fontsize]">
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15" selected>15</option>
  <option value="16">16</option>
   <option value="17">17</option>
  <option value="18">18</option>
</select>
                     </div>  <div class="clearfix"><!-- SOCIAL MEDIA LINKS --></div><br>

                                                     <div class="col-sm-12 col-md-12 text-left">
  <label for="font">Template</label><br>

  <input type="checkbox" name="Sender[template1]" value="none" checked> Design1<br>
    <input type="checkbox" name="Sender[template]" value="none"> Design2<br>


                     </div>
        </div>
</div>

         <div class="clearfix"><!-- SOCIAL MEDIA LINKS --></div><br>

    <div class="col-sm-12 col-md-12 text-center">
            <button id="preview" type="submit" class="btn btn-default">Preview</button>
         
            <button id="download" class="btn btn-default">Download</button>

         
            <input type="hidden" name="download" id= "will-download" value="">

            <!--action buttons -->       <button id="Refresh" type="reset" class="btn btn-default">Refresh</button>
                  </div>

                      </div>
        </form>
    </div>
    <br>
    <div class="container">
        <!-- preview box -->
        <iframe src="about:blank" name="preview" width="100%" height="600"></iframe>


<!--            <iframe src="about:blank" name="preview2" width="100%" height="400"></iframe>
 -->    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <script src="/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
       $('#cp2').colorpicker();
//        $("#cp2").on('colorpicker', function(){

// });
        $("#download").bind("click", function () {
            $('#will-download').val('true');
            $('#form').removeAttr('target').submit();
        });

        $("#preview").bind("click", function () {
            $('#will-download').val('');
            $('#form').attr('target', 'preview');
            // $('#phonepre').val('p');



                 if($('#companyPhone').val() !== ''){
$('#phonepre').val('p &nbsp;');


   }



                    if($('#Email').val() !== ''){
$('#emailepre').val('e &nbsp;');


   }


                    if($('#webshow').val() !== ''){
$('#webpre').val('w &nbsp;');


   }


                    if($('#street').val() !== ''){
$('#addressepre').val('a &nbsp;');


   }

                    if($('#personalPhone').val() !== ''){
$('#mobileepre').val('m &nbsp;');


   }



        });

           $("#preview2").bind("click", function () {
            $('#will-download').val('');
            $('#form').attr('target', 'preview2');
     });
        /*  Phone Number Masking */
        $("input.phone").keyup(function () {
            $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "$1 $2 $3"));
        });

    });








</script>
</body>
</html>
<?php endif;