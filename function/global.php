<?php
    function dbRowInsert($table_name, $form_data, $connect){
        include $connect;
            // retrieve the keys of the array (column titles)
            $fields = array_keys($form_data);

            // build the query
            $sql = "INSERT INTO ".$table_name."
            (`".implode('`,`', $fields)."`)
            VALUES('".implode("','", $form_data)."')";

            // run and return the query result resource
            return mysqli_query($con, $sql);
    }
    
    function dbRowUpdate($connect, $table_name, $form_data, $where_clause='')
    {
        include $connect;
        // check for optional where clause
        $whereSQL = '';
        if(!empty($where_clause))
        {
            // check to see if the 'where' keyword exists
            if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
            {
                // not found, add key word
                $whereSQL = " WHERE ".$where_clause;
            } else
            {
                $whereSQL = " ".trim($where_clause);
            }
        }
        // start the actual SQL statement
        $sql = "UPDATE ".$table_name." SET ";

        // loop and build the column /
        $sets = array();
        foreach($form_data as $column => $value)
        {
             $sets[] = "`".$column."` = '".$value."'";
        }
        $sql .= implode(', ', $sets);

        // append the where statement
        $sql .= $whereSQL;

        // run and return the query result
        return mysqli_query($con, $sql);
    }

    function teacherInfo($t_idscan, $output, $connect){
        include $connect;
        $sql = mysqli_query($con, "SELECT * FROM teachers WHERE t_idscan='$t_idscan'");
        $result = mysqli_fetch_array($sql);
        switch ($output){
            case 't_id':
                return str_replace("\'", "&#39;", $result["t_id"]);
                break;
            case 't_fnameRumi':
                return str_replace("\'", "&#39;", $result["t_fnameRumi"]);
                break;
            case 't_lnameRumi':
                return str_replace("\'", "&#39;", $result["t_lnameRumi"]);
                break;
            case 'tp_id':
                return str_replace("\'", "&#39;", $result["tp_id"]);
                break;
            case 't_photo':
                return str_replace("\'", "&#39;", $result["t_photo"]);
                break;
        }
    }
    
    function positionInfo($tp_id, $output, $connect){
        include $connect;
        $sql = mysqli_query($con, "SELECT * FROM teacher_position WHERE tp_id='$tp_id'");
        $result = mysqli_fetch_array($sql);
        switch ($output){
            case 'tl_id':
                return str_replace("\'", "&#39;", $result["tl_id"]);
                break;
            case 'tp_name_rm':
                return str_replace("\'", "&#39;", $result["tp_name_rm"]);
                break;
        }
    }
    
    function timelogInfo($tl_id, $output, $connect){
        include $connect;
        $sql = mysqli_query($con, "SELECT * FROM time_log WHERE tl_id='$tl_id'");
        $result = mysqli_fetch_array($sql);
        switch ($output){
            case 'tl_time_start':
                return str_replace("\'", "&#39;", $result["tl_time_start"]);
                break;
            case 'tl_time_late':
                return str_replace("\'", "&#39;", $result["tl_time_late"]);
                break;
            case 'tl_end_late':
                return str_replace("\'", "&#39;", $result["tl_end_late"]);
                break;
            case 'tl_time_back':
                return str_replace("\'", "&#39;", $result["tl_time_back"]);
                break;
        }
    }

?>

