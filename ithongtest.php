<?php
//array for JSON response
$response = array();
//include db_connect file
require_once ('db_connect.php');

//connect db
$db = new DB_CONNECT();
date_default_timezone_set('Asia/Ho_Chi_Minh');
//dungna
//$db = mysqli_connect('localhost', 'root','','ithongtest40');
//$db = mysql_connect('localhost', 'root','','ithongtest');
    
    // neu ket noi khong thanh cong, thi bao loi ra
    //if(!$db) {
     //   trigger_error("Could not connect to DB: " . mysqli_connect_error());
   // } else {
        // dat phuong thuc ket noi la utf-8
        //mysqli_set_charset($db, 'utf-8');
   // }

/**
*   Author: Dungna
*   Date: Tuesday, March 10 2015
*   check if server update then sync with client (Android app)
*   input: $sync: true or false
**/
if (isset($_GET['sync']) && isset($_GET['last_update'])) {
   $last_update  = $_GET['last_update'];
   $sql = "SELECT * FROM keywords WHERE LastUpdated > DATE_FORMAT({$last_update},'%Y-%m-%d %H:%i:%s')";
   $result = mysql_query($sql) or die(mysql_error());
   $num_rows = mysql_num_rows($result);
   if($num_rows > 0){
        $response['Keyword'] = array();
         while ($row = mysql_fetch_array($result))
        {
            //temp array
            $keyword = array();
            $keyword['Keyword_ID'] = $row['Keyword_ID'];
            $keyword['Keyword_Name'] = $row['Keyword_Name'];
            $keyword['Keyword_NameEN'] = $row['Keyword_NameEN'];
            $keyword['Sort'] = $row['Sort'];
            $keyword['LastUpdated'] = $row['LastUpdated'];
            //push data into final response array
            array_push($response['Keyword'], $keyword);
        }
        //code
        $response['count'] = $num_rows;
        $response['code'] = 1;

        //echo JSON
        echo json_encode($response);
   }else{
        //no response
        $response['message'] = "No data to update";
        $response['count'] = $num_rows;
        $response['code'] = 0;
        echo json_encode($response);
   }

}

/**
*   Author: Dungna
*   Date: Wednesday, March 11 2015
*   get all key when user select search online (Android app)
*   input: $search online: true or false
**/
if (isset($_GET['search_online'])) {
   $search_online  = $_GET['search_online'];
   $sql = "SELECT * FROM violation";
   $result = mysql_query($sql) or die(mysql_error());
   $num_rows = mysql_num_rows($result);
   if($num_rows > 0){
        $response['Violation'] = array();
        while ($row = mysql_fetch_array($result))
        {
            //temp array
            $Violation = array();
            $Violation['ID'] = $row['ID'];
            $Violation['Object'] = $row['Object'];
            $Violation['Name'] = $row['Name'];
            $Violation['NameEN'] = $row['NameEN'];
            $Violation['LawID'] = $row['LawID'];
            $Violation['Bookmark_ID'] = $row['Bookmark_ID'];
            $Violation['IsWarning'] = $row['IsWarning'];
            $Violation['IsPoppular'] = $row['IsPoppular'];
            $Violation['MainContent'] = $row['MainContent'];
            $Violation['Fines'] = $row['Fines'];
            $Violation['Additional_Penalties'] = $row['Additional_Penalties'];
            $Violation['Remedial_Measures'] = $row['Remedial_Measures'];
            $Violation['Other_Penalties'] = $row['Other_Penalties'];
            $Violation['Group_Value'] = $row['Group_Value'];
            $Violation['Type_Value'] = $row['Type_Value'];
            $Violation['LawTitle'] = $row['LawTitle'];
            $Violation['Disabled'] = $row['Disabled'];
            $Violation['LastUpdated'] = $row['LastUpdated'];

            //push data into final response array
            array_push($response['Violation'], $Violation);
        }
        //code
        $response['count'] = $num_rows;
        $response['code'] = 1;

        //echo JSON
        echo json_encode($response);
   }else{
        //no response
        $response['message'] = "No data to update";
         $response['count'] = $num_rows;
        $response['code'] = 0;
        echo json_encode($response);
   }

}

/**
*   Author: Dungna
*   Date: Wednesday, March 11 2015
*   for test: update keywords (Android app)
*   input: $search online: true or false
**/
if (isset($_GET['update_keyword']) && isset($_GET['id'])) {
   $update_keyword  = $_GET['update_keyword'];
  // echo "string";
  // echo $_GET['id'];


   $keyword_id  = $_GET['id'];
   //$last_keyword = $last_keyword + 1;
   $date = date('Y-m-d H:i:s');
   //echo $date;
   $sql = "INSERT INTO keywords VALUES('{$update_keyword}','{$update_keyword}',0,'{$date}')";
   //echo "$sql";
   $result = mysql_query($sql) or die(mysql_error());
   //echo "can't insert";

    //check update to database
    if (mysql_affected_rows() > 0)
    {
        $response['Keyword'] = array();
        $response['code'] = 1;
        $response['message'] = "update sussessful";
        echo json_encode($response);
    } else
    {
        //no place found
        $response['code'] = 0;
        $response['message'] = "Can't update to this database. Please check and try again.";
        echo json_encode($response);
    }

}

//-----------------------------
//test
//$date = new DateTime('2000-01-01');
//$result = $date->format('Y-m-d H:i:s');
//echo strtotime('22-09-2015');
?>