<?php
$file_dir_name = dirname(__FILE__);

// here was old const php
// old include of afw_debugg.php
// old include of afw.php
//AFWObject::setDebugg(true);
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);


include_once("$file_dir_name/../external/db_config.php") ;

/*
$host = $Host;
$user = $User;
$password = $Password;
$database = $Database;


$db_1 = AfwDbMysql::getInstance();
$db_1->Database=$server_db_prefix.$Database;
$db_1->Host=$Host;
$db_1->User=$User;
$db_1->Password=$Password;
$db_1->Halt_On_Error="yes";
$db_1->Debug=true;*/



$cache_management = true;
         
if(!isset($arr_AroleByCode)) $arr_AroleByCode = array();         
if(!isset($_sql_analysis)) $_sql_analysis = array();
//if(!isset($_cache_analysis)) $_SERVER["cache_analysis"] = array();
if(!isset($_page_cache_objects)) $_page_cache_objects = array();
if(!isset($_lmany_analysis)) $_lmany_analysis = array();

if(!isset($get_stats_analysis)) $get_stats_analysis = array();

// $not _allowed_get = array();
// $not _allowed_get["module"]["tome"] = true;


require_once("$file_dir_name/../lib/afw/common.php");
require_once("$file_dir_name/../lib/afw/common_date.php");
require_once("$file_dir_name/../lib/afw/common_string.php");



// if query is called more than $_sql_analysis_seuil_calls times it craches to make analysis of reason
$_sql_analysis_seuil_calls = 700;
$_sql_analysis_total_seuil_calls = 5000;
$loadMany_max = 1000;
// change below the $errors_check_count_max var by adding 1 or removing 1 to see where it crashes in infinite loop (attribute error check)
$errors_check_count_max = 1201;
$errors_check_count = 0;


$cacheSys = AfwCacheSystem::getSingleton();

// rafik @todo : to be in external class like AfwCacheSystem
/*
function sql_query_cache_analysis()
{
     global $_sql_analysis, $_sql_analysis_seuil_calls;
       
     echo "<b>SQL Query Optimizer stats : </b><br>";
     
     $_sql_analysis_orange_seuil = round($_sql_analysis_seuil_calls*0.5);
     $_sql_analysis_red_seuil = round($_sql_analysis_seuil_calls*0.75);
     
     $_sql_analysis_max_calls = 0;
     
     foreach($_sql_analysis as $module_code => $_sql_analysis_by_module)
     {
           echo "<br>";
           echo "<table class='display dataTable table_obj'>";
           echo "<tr>";
           echo "     <th colspan='3' align='center'><b>Module : $module_code</b></th>";
           echo "</tr>";
           echo "<tr>";
           echo "     <th>SQL</th>";
           echo "     <th>Calls</th>";
           echo "</tr>";
           foreach($_sql_analysis_by_module as $table_name => $_analysis_item)
           {
                 foreach($_analysis_item as $sql_q => $nb_call)
                 {
                    $classe="";
                    if($nb_call>=$_sql_analysis_orange_seuil) $classe="warning";
                    if($nb_call>=$_sql_analysis_red_seuil) $classe="error";
                    
                    
                    if($nb_call>=$_sql_analysis_orange_seuil)
                    {     
                        echo "<tr>";
                        echo "     <td><pre class='$classe'>$sql_q</pre></td>";
                        echo "     <td>$nb_call</td>";
                        echo "</tr>";
                    }
                    
                    if($nb_call>=$_sql_analysis_max_calls)
                    {
                          $_sql_analysis_max_calls = $nb_call;
                    }    
                 }
           }
           echo "</table><br>";
           echo "Max calls = $_sql_analysis_max_calls<br>";
           echo "<br>";
     }

}




function show_get_analysis()
{
     global $get_stats_analysis;
       
        $message = "";
        
        foreach($get_stats_analysis as $table_code => $get_stats_objects)
        {
             
             foreach($get_stats_objects as $attribute => $get_attribute_objects)
             {
                    $message .= "<hr>gots for table=$table_code, attribute=$attribute : <hr><br>";
                    $message .= "<table dir='ltr' class='grid'>";
                    $message .= "<tr><th><b>ID</b></th><th><b>attribute</b></th><th><b>object-format</b></th><th><b>decode-format</b></th><th><b>value-format</b></th></tr>";
                    foreach($get_attribute_objects as $id => $get_attribute_object_whats)
                    {
                            $get_object = $get_attribute_object_whats["object"];
                            $get_decode = $get_attribute_object_whats["decode"];
                            $get_value = $get_attribute_object_whats["value"];
                            if($get_object>3) $get_object = "<span class='error'>$get_object</span>";
                            if($get_decode>6) $get_decode = "<span class='error'>$get_decode</span>";
                            if($get_value>10) $get_value = "<span class='error'>$get_value</span>";
                            
                            
                            $message .= "<tr><td>$id</td><td>$attribute</td><td>$get_object</td><td>$get_decode</td><td>$get_value</td></tr>";
                            
                    }
                    $message .= "</table><hr>";
             }
        
        }
        
        return $message;

}             

@note rafik/17/6/2021 obsolete and fill the session of user better to remove
function resetLinkInSession($sslnk)
{
     global $_SE SSION;
     $_SES SION["SessionLinkLastId"] = 0;
     $ss_link = $_SESS ION["SessionLink"][$sslnk];
     
     unset($_SE SSION["SessionLink"]);
     
     $_SESSI ON["SessionLink"][$sslnk] = $ss_link;
}

function saveLinkInSession($link)
{
     list($link_page,$link_page_params) = explode("?",$link);
     
     $link_page_params_arr = explode("&",$link_page_params);
     $link_page_params_table = array();
     foreach($link_page_params_arr as $link_page_param_item)
     {
          $link_page_param_tab = explode("=",$link_page_param_item);
          
          $param_name = $link_page_param_tab[0];
          unset($link_page_param_tab[0]);
          $param_val = implode("=",$link_page_param_tab);
          
          $link_page_params_table[$param_name] = $param_val;
     }
     
     return savePageInSession($link_page,$link_page_params_table);
}
     
function savePageInSession($link_page,$link_page_params_table)
{     
     global $_SE SSION;
     
     if(!$_SESS ION["SessionLinkLastId"]) $_SE SSION["SessionLinkLastId"] = 0;
     $_S ESSION["SessionLinkLastId"]++;
     $newSessionLinkId = $_S ESSION["SessionLinkLastId"];
     
     if($_S ESSION["SessionLink"][$newSessionLinkId])
     {
         $_SES SION["SessionLinkLastId"]++;
         $newSessionLinkId = $_S ESSION["SessionLinkLastId"];
     }
     
     $_SESS ION["SessionLink"][$newSessionLinkId] = array("page"=>$link_page, "params"=>$link_page_params_table);
     
     
     return "main.php?sslnk=".$newSessionLinkId;
     
}
*/

