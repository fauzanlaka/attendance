<?php
    session_start();
    //$_SESSION['id']="1";
    //$id=$_SESSION['id'];
    $t_id = $_GET['t_id'];
    include 'connect/connect.php';
    $name = date('YmdHis');
    $newname="photoCheck/".$name."+".$t_id.".jpg";
    $photo = $name."+".$t_id.".jpg";
    $dateNow = date('Y-m-d');
    
    $file = file_put_contents( $newname, file_get_contents('php://input') );
    if (!$file) {
            print "Error occured here";
            exit();
    }
    else
    {
        $sql=mysqli_query($con, "UPDATE daily_check SET dc_photo_capture='$photo' WHERE t_id='$t_id' AND dc_come_check_date='$dateNow'");
        //$result=mysqli_query($con,$sql);
        //$value=mysqli_insert_id($con);
        //$_SESSION["myvalue"]=$value;
    }

    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $newname;
    print "$url\n";

?>
2017082809225813