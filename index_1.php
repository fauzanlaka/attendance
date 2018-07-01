<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>TVM - กล้องถ่ายรูป</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../../css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body{
            margin:0;
            padding:0;
        }
        .img
            { background:#ffffff;
            padding:12px;
            border:1px solid #999999; }
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
    <body style="background-color:#dfe3ee;">
        <div class="container">
            <?php
                $std_id = $_GET['std_id'];
            ?>
            <div id="main" style="height:800px; width:100%">
                
                <div id="content" style="float:left; width:500px; margin-left:50px; margin-top:20px;" align="center">
                    <h4 class="text-center">กล้องถ่ายรูป</h4>
                    <h5 class="text-center text-warning">(คลิก Allow)</h5>
                    <script type="text/javascript" src="webcam.js"></script>
                    <script language="JavaScript">
                        document.write( webcam.get_html(400, 450) );
                    </script>
                    <form>
                        <br/>
                        <a onClick="webcam.configure()" class="btn btn-success"><span class="glyphicon glyphicon-cog"></span> ตั้งค่า</a>
                        &nbsp;&nbsp;
                        <a onClick="take_snapshot()" class="btn btn-success"><span class="glyphicon glyphicon-camera"></span> ถ่ายรูป</a>
                    </form>
                </div>
                <br><br><br>
                <div id="img" style=" height:800px; width:500px; float:left; margin-left:40px; margin-top:20px;"></div>
            
            </div>
        </div>
        
        <script  type="text/javascript">
            var std_id = <?php echo $std_id; ?>;
            webcam.set_api_url( 'handleimage.php?std_id='+std_id );
            webcam.set_quality( 90 ); // JPEG quality (1 - 100)
            webcam.set_shutter_sound( true ); // play shutter click sound
            webcam.set_hook( 'onComplete', 'my_completion_handler' );

            function take_snapshot(){
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