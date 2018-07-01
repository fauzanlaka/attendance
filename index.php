<?php
    include 'connect/connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>JISDA Attendance</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">
    
    <!-- font -->
    <link href="font/font.css" rel="stylesheet"> 
    
    <!-- tvm style -->
    <link href="css/tvm_style.css" rel="stylesheet"> 
    
    <!-- indicator -->
    <link href="css/indicator.css" rel="stylesheet"> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        body{
            margin:0;
            padding:0;
        }
        .shiva{
            -moz-user-select: none;
            background: #2A49A5;
            border: 1px solid #082783;
            box-shadow: 0 1px #4C6BC7 inset;
            color: white;
            padding: 3px 5px;
            text-decoration: none;
            text-shadow: 0 -1px 0 #082783;
            font: 12px Verdana, sans-serif;}
    </style>

</head>

<body style="background-color: #f5f5f5">

    <!-- Page Content -->
    <div class="container">
        
        <div class="row">

            <div class="col-md-12">
                
                <div align="center">
                    <img src="image/jisda.png" width="15%" height="15%">
                </div>
                <h1 class="text-center">JISDA ATTENDANCE</h1>
               
                <table class="table">
                    <tr>
                        <td align="center" width="25%">
                                <script type="text/javascript" src="webcam.js"></script>
                                <script language="JavaScript">
                                    document.write( webcam.get_html(400, 450) );
                                </script>
                                <form>
                                    <br/>
                                    <a onClick="webcam.configure()" class="btn btn-success"> setting</a>
                                    &nbsp;&nbsp;
                                    <!--<a onClick="take_snapshot()" class="btn btn-success"> ถ่ายรูป</a>-->
                                </form>
                            </div>
                        </td>
                        <td align="center" width="25%">
                            <div id="img" style=" height:450; width:400px;"></div>
                        </td>
                        <td align="center" width="25%">
                            <div id="photo">
                                <img src="image/staff.jpg" width="400" height="450">
                            </div>
                        </td>
                        <td align="left" width="25%">
                            <div id="checking"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <form name="teacherForm" id="teacherForm">
                                <input type="password" class="form-control text-center" width="500px" name="teacher" id="teacher" onkeyup="check(this.value)" onkeypress="return checkEnter()" autofocus="">
                            </form>   
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
    <!-- /.container -->


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Ajax -->
    <script type="text/javascript" src="ajax/framework.js"></script>
    <script type="text/javascript" src="ajax/private.js"></script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112468523-3"></script>
    <script  type="text/javascript">
            

            function take_snapshot(t_id){
                webcam.set_api_url( 'handleimage.php?t_id=' +  t_id);
                webcam.set_quality( 90 ); // JPEG quality (1 - 100)
                webcam.set_shutter_sound( true ); // play shutter click sound
                webcam.set_hook( 'onComplete', 'my_completion_handler' );
                // take snapshot and upload to server
                document.getElementById('img').innerHTML = '<h1>กำลังอัพโหลด...</h1>';
                webcam.snap();
            }

            function my_completion_handler(msg) {
                // extract URL out of PHP output
                if (msg.match(/(http\:\/\/\S+)/)) {
                    // show JPEG image in page
                    document.getElementById('img').innerHTML ='<h3>Upload Successfuly done</h3>'+msg;
                    document.getElementById('img').innerHTML ="<img src="+msg+" class=\"img\">";
                    // reset camera for another shot
                    webcam.reset();
                    }else {
                        alert("Error occured we are trying to fix now: " + msg); }
                    }
        </script>

</body>

</html>