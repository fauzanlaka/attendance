<?php
    header("content-type: text/javascript");
    include '../connect/connect.php';
    include 'global.php';
    $connect = '../connect/connect.php';
    $t_idscan = $_POST['teacher'];
    
    //ตรวจสอบข้อมูลบุคลากรจากรหัสบัตร
    $staff = mysqli_query($con, "SELECT * FROM teachers WHERE t_idscan='$t_idscan'");
    $numstaff = mysqli_num_rows($staff);
    
    if($numstaff>0){
        //ข้อมูลบุคลากรจากรหัสที่ได้รับ
        $t_id = teacherInfo($t_idscan, 't_id', $connect);
        $t_fnameRumi = teacherInfo($t_idscan, 't_fnameRumi', $connect);
        $t_lnameRumi = teacherInfo($t_idscan, 't_lnameRumi', $connect);
        $t_photo = teacherInfo($t_idscan, 't_photo', $connect);
        $tp_id = teacherInfo($t_idscan, 'tp_id', $connect);
        $tl_id = positionInfo($tp_id, 'tl_id', $connect);

        $photo = "<img src=\"../../idarah2/module/staff/photo/$t_photo\" width=\"400px\" height=\"450px\">";
        
        //ตรวจสอบเวลาเพื่อบันทึกการแสกน
        $tl_start_time = timelogInfo($tl_id, 'tl_time_start', $connect);
        $tl_start_late = timelogInfo($tl_id, 'tl_time_late', $connect);
        $tl_end_late = timelogInfo($tl_id, 'tl_end_late', $connect);
        $tl_time_back = timelogInfo($tl_id, 'tl_time_back', $connect);
        $timeNow = date("H:i:s");
        
        //ตัวแปรเพื่อการเปรียบเทียบ
        $tl_start = str_replace(':', '', $tl_start_time);
        $tl_late = str_replace(':', '', $tl_start_late);
        $tl_end = str_replace(':', '', $tl_end_late);
        $tl_back = str_replace(':', '', $tl_time_back);
        $tnow = str_replace(':', '', $timeNow);
        
        if($tnow <= $tl_start){
            $checkStatus = "<font color=\'red\'>Bukan masa scan</font>"; //แสดงเวลาเข้างาน
        }else if($tnow >= $tl_start AND $tnow < $tl_late){ //ถ้ามาตรงเวลา
            $dateNow = date('Y-m-d');
            $beforCheck = mysqli_query($con, "SELECT * FROM daily_check WHERE t_id='$t_id' AND dc_come_check_date='$dateNow'");
            $num = mysqli_num_rows($beforCheck);
            if($num<1){//ถ้ายังไม่มีการแสกน
                $form_data = array(
                    't_id' => $t_id,
                    'dc_come_check' => $timeNow,
                    'dc_come_check_date' => date('Y-m-d')
                );
                //บันทึกการแสกนเข้างาน
                dbRowInsert('daily_check', $form_data, $connect);
                $checkStatus = $timeNow; //แสดงเวลาเข้างาน
            }else{
                //ถ้ามีการแสกนแล้ว
                $checkStatus = "<font color=\'green\'>".$timeNow."</font>"; //แสดงเวลาเข้างาน
            }
            
        }elseif($tnow > $tl_late AND $tnow <= $tl_end){ //ถ้ามาสาย
            $dateNow = date('Y-m-d');
            $beforCheck = mysqli_query($con, "SELECT * FROM daily_check WHERE t_id='$t_id' AND dc_come_check_date='$dateNow'");
            $num = mysqli_num_rows($beforCheck);
            if($num<1){//ถ้ายังไม่มีการแสกน
                $form_data = array(
                    't_id' => $t_id,
                    'dc_come_check' => $timeNow,
                    'dc_come_check_date' => date('Y-m-d')
                );
                //บันทึกการแสกนเข้างาน
                dbRowInsert('daily_check', $form_data, $connect);
                $checkStatus = "Terlambat"; //แสดงเวลาเข้างาน
            }else{
                //ถ้ามีการแสกนแล้ว
                $checkStatus = "<font color=\'red\'>Terlambat</font>"; //แสดงเวลาเข้างาน
            }
        }elseif($tnow >= $tl_back){ //ถ้าแสกนออกงาน
            $dateNow = date('Y-m-d');
            $getBackTeacher = mysqli_query($con, "SELECT * FROM daily_check WHERE t_id='$t_id' AND dc_come_check_date='$dateNow'");
            $resultNum = mysqli_num_rows($getBackTeacher);
            $resultBack = mysqli_fetch_array($getBackTeacher);

            if($resultNum>0){
                $form_data = array(
                    'dc_back_check' => $timeNow,
                );
                dbRowUpdate($connect, "daily_check", $form_data, "WHERE t_id='$t_id' AND dc_come_check_date='$dateNow'");
                $checkStatus = $timeNow; //แสดงเวลาออกงาน
            }else{
                $checkStatus = "Tidak masuk kerja pagi"; //แสดงเวลาออกงาน
            }
        }else{
            $checkStatus = "<font color=\'red\'>Bukan masa scan</font>";
        }
        //รายละเอียดบุคลากร
        $t_data = "";
        $t_data .= "<h3><b>Nama-Nasab : </b>"; //Nama-nasab
        $t_data .= $t_fnameRumi;
        $t_data .= " ";
        $t_data .= $t_lnameRumi;
        $t_data .= "</h3>";
        $t_data .= "<h3><b>Hari tanggal : </b>".date("l")." ".date('Y-m-d');
        $t_data .= "<h3><b>Masa scan : </b>".$checkStatus;
        $t_data .= "<h3><b>Position : </b>".  positionInfo($tp_id, 'tp_name_rm', $connect);
        
        echo "document.getElementById('teacherForm').reset();";
        echo "document.getElementById('teacher').focus();";
        echo "document.getElementById('checking').innerHTML = \"$t_data\";";
        echo "document.getElementById('photo').innerHTML = '$photo';";
        echo "take_snapshot('$t_id');";
    }else{
        $t_data = "";
        $t_data .= "<h3><font color=\'red\'>Tidak jumpa data</font></h3>";
        //echo "take_snapshot();";
        echo "document.getElementById('teacherForm').reset();";
        echo "document.getElementById('teacher').focus();";
        echo "document.getElementById('checking').innerHTML = '$t_data';";
        echo "document.getElementById('photo').innerHTML = '<img src=\"image/staff.jpg\" width=\"400px\" height=\"450px\">';";
        
    }
    
?>

