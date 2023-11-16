<?php
ob_start();
$file_dir_name = dirname(__FILE__); 



 

session_start();

require_once("common.php");
$only_members = true;
include("check_member.php");

require_once("afw.php");
require_once(".db_access.php");
require_once("afw_rights.php");
require_once("afw_config.php");
require_once("afw_shower.php");



global $objme;

$pm_id = $_REQUEST["pm_id"];
$mih = $_REQUEST["mih"];
if(!$mih) $mih = "0,1,2,3,4";
$mih_arr = explode(",",$mih);
$mih_index = array();
foreach($mih_arr as $mih_i) $mih_index[$mih_i] = true;

$mih_trad[1] = "المحور الأول";
$mih_trad[2] = "المحور الثاني";
$mih_trad[3] = "المحور الثالث";
$mih_trad[4] = "المحور الرابع";
$mih_trad[5] = "المحور الخامس";
$mih_trad[6] = "المحور السادس";
$mih_trad[7] = "المحور السابع";


$mih_title[1] = "المعلومات المؤتمتة والجاهزة لتغذية منصة الذكاء";
$mih_title[2] = "المعلومات اليدوية (موضوع اقتراح الحافظة الالكترونية)";
$mih_title[3] = "المعلومات الغير موجودة في المنصة وجار التأكد من وجود أنظمة لها";
$mih_title[4] = "المعلومات المتوفرة في منصة الذكاء";
$mih_title[5] = "5555555555555555";
$mih_title[6] = "6666666666666666";
$mih_title[7] = "77777777777777777";



$mih_desc_html[1] = "<br>يبين قائمة المعلومات التي ليست بعد في منصة الذكاء ولكن تم تحديد الأنظمة التي تتعامل بها ليبدأ فريق منصة الذكاء العمل عليها من أجل توفيرها بشكل مناسب للمستخدم<br>
ملاحظة 1: بعض الأنظمة المشار إليها سابقا لا تزال تحت الدراسة والتطوير فلا يمكن حاليا الربط معها حتى تستقر هذه الأنظمة على نسخة متينة وتوضع في طور الإنتاج وبإمكان فريق منصة الذكاء التعرف عليها في الجدول بأن تكون الحالة 'انتظار' على غرار 'جاهزة' (انظر العمود تغذية منصة الذكاء) ف'انتظار' تعني أن النظام لم يوضع بعد في طور الإنتاج فيجب الانتظار إلى حين إطلاقه و'جاهزة' تعني أن فريق المنصة أصبح عنده الضوء الأخضر لترحيلها إلى منصة الذكاء. <br>
ملاحظة 2: المعلومات الجاهزة لترحيلها إلى منصة ذكاء الأعمال مرتبة في هذا التقرير حسب الأولوية (ذوات الأولوية العالية ثم التي تليها وهكذا) <br>
";

$mih_desc_html[2] = 'يبين قائمة المعلومات التي هي ليست في منصة الذكاء ولا يوجد نظام ممكن أن تستخرج منه آليا ولكنها متوفرة ورقيا ونحو ذلك عند الإدارة التي تملكها فيجب أن يتم إدخالها يدويا في نظام خاص يكون بمثابة الجسر إلى منصة الذكاء. وقد تم اقتراح تطوير نظام "الحافظة الالكترونية لإدخال البيانات الغير المؤتمتة" والذي قام المهندس رفيق بشرح الفكرة العامة له لمدير ادارة التخطيط ولرئيس قسم التطوير فطلب مدير إدارة التخطيط الأستاذ عبد الخالق عبد الله آل مشاري انجاز نموذج أولي من هذا الحل لصالح إدارة التخطيط قبل التعميم على بقية الإدارات، ونحن بصدد العمل عليه على أن يتم هذا الإنجاز في خلال أسبوع كأقصى تقدير بإذن الله تعالى.';

$mih_desc_html[3] = "يبين قائمة المعلومات التي ليست في منصة الذكاء وجار التأكد من وجود أنظمة تتعامل بها وسوف يتم العمل عليها على مستوى فريق إدارة التخطيط والإحصاء من أجل تذليل العوائق لمعرفة وجود أنظمة لها. في هذا الإطار نقترح أن يتم التواصل مع فريق البنية المؤسسية تحت إشراف المهندس عبدالرحمن السويد مساعد المدير العام للمكتب الاستراتيجي عسى أن يكون عندهم مساعدة قيمة في الموضوع<br>";

$mih_desc_html[4] = "يبين قائمة المعلومات المتوفرة في منصة الذكاء وهذه جاهزة للإستخدام من قبل إدارتي التخطيط والإحصاء<br>";
$mih_desc_html[5] = "5555555555555555";
$mih_desc_html[6] = "6666666666666666";
$mih_desc_html[7] = "77777777777777777";

$mih_order_arr = array();

if($mih_index[4]) $mih_order_arr[] = 4;
if($mih_index[1]) $mih_order_arr[] = 1;
if($mih_index[2]) $mih_order_arr[] = 2;
if($mih_index[3]) $mih_order_arr[] = 3;


if(!$pm_id) $pm_id = 6;  
if($pm_id)
{
        
        require_once "../bau/gfield.php";
        
        
        
        require_once "../sdd/sempl.php";

        if($mih_index[0])
        {
                $parent_module = new Module();
                $parent_module->load($pm_id);
                $parent_module_name = $parent_module->valTitre();
                $parent_doc_name = "دراسة ".$parent_module_name;
                $parent_sh = $parent_module->hetMainSH();
                
                
                // chercher les participants au projet (FU)
                
                $module_fu = new ModuleAuser();
                $module_fu->select("id_module",$pm_id);
                //$module_fu->where("arole_mfk like '%,1,%'");
                $module_fu->select("avail",'Y');
                $module_fu_list = $module_fu->loadMany("","description asc");
        
        
                $md = new Module();
                
                $md->where("id in (select distinct gf.module_id from c0bau.gfield gf where gf.parent_module_id=$pm_id and gf.avail = 'Y') and id_module_parent in (22,72)");
                
                list($html_arrA, $liste_objA, $idsA) = showMany($md,"id_br,id_pm,id_main_sh,id_module_status,titre",$objme, null, "", "", true, "grid", "tr_1", "tr_2", "tr_0", "ar", "rtl", "بيانات الأنظمة المهمة لهذا المشروع", "bigtitle", $width_th_arr, "275mm",24);
        
        
                
                $au = new Sempl();
                
                $au->where("id in (select distinct owner_id from c0bau.gfield where parent_module_id=$pm_id and avail = 'Y')");
                
                list($html_arrB, $liste_objB, $idsB) = showMany($au,"mobile,phone,email,job,id_sh_div,nomcomplet,id",$objme, null, "", "", true, "grid", "tr_1", "tr_2", "tr_0", "ar", "rtl", "بيانات التواصل مع المسؤولين", "bigtitle", $width_th_arr, "275mm",24);
        }
                


        $sh_list_arr = array();
        $html_arr_mih = array();        
        
        // mih 1
        
        if($mih_index[1])
        {
                $cond_mihwar = "and module_id not in (0, 19, 16, 5)";
                $sh = new Orgunit();
                
                $sh->where("id in (select distinct stakeholder_id from c0bau.gfield where parent_module_id=$pm_id and avail = 'Y' $cond_mihwar)");
                $sh_list_arr[1] = $sh->loadMany();
        
                
                $html_arr_mih[1] = array();
                
                
                foreach($sh_list_arr[1] as $id_sh => $sh_item)
                {
                     $sh_item_titre = "المعلومات المتوفرة عند ".$sh_item->valTitre();
                     unset($gfield);
                     $gfield = new Gfield();
                     $gfield->where("stakeholder_id = $id_sh and parent_module_id=$pm_id and avail = 'Y' $cond_mihwar");
                     $width_th_arr = array("owner_id"=>"48mm", "module_id"=>"48mm", "gfield_cat_id"=>"31mm", "titre"=>"96mm", "id"=>"17mm");
                     list($html_arr_mih[1][$id_sh], $liste_obj_1, $ids_1) = showMany($gfield,"gf_status,owner_id,module_id,titre,id",$objme, null, "", "", true, "grid", "tr_1", "tr_2", "tr_0", "ar", "rtl", $sh_item_titre, "bigtitle", $width_th_arr, "240mm",24); // -- ,gfield_cat_id
                }
        }
        // mih 2
        if($mih_index[2])
        {
                unset($sh);
        
                $cond_mihwar = "and module_id = 16";
                $sh = new Orgunit();
                
                $sh->where("id in (select distinct stakeholder_id from c0bau.gfield where parent_module_id=$pm_id and avail = 'Y' $cond_mihwar)");
                $sh_list_arr[2] = $sh->loadMany();
                
                $html_arr_mih[2] = array();
        
                foreach($sh_list_arr[2] as $id_sh => $sh_item)
                {
                     $sh_item_titre = "المعلومات المتوفرة عند ".$sh_item->valTitre();
                     unset($gfield);
                     $gfield = new Gfield();
                     $gfield->where("stakeholder_id = $id_sh and parent_module_id=$pm_id and avail = 'Y' $cond_mihwar");
                     $width_th_arr = array("owner_id"=>"48mm", "module_id"=>"48mm", "gfield_cat_id"=>"31mm", "titre"=>"96mm", "id"=>"17mm");
                     list($html_arr_mih[2][$id_sh], $liste_obj, $ids) = showMany($gfield,"gf_status,owner_id,module_id,titre,id",$objme, null, "", "", true, "grid", "tr_1", "tr_2", "tr_0", "ar", "rtl", $sh_item_titre, "bigtitle", $width_th_arr, "240mm",24); // ,gfield_cat_id
                }
        }        
                
        // mih 3
        if($mih_index[3])
        {
                unset($sh);
                $cond_mihwar = "and module_id in (0, 19)";
                $sh = new Orgunit();
                
                $sh->where("id in (select distinct stakeholder_id from c0bau.gfield where parent_module_id=$pm_id and avail = 'Y' $cond_mihwar)");
                $sh_list_arr[3] = $sh->loadMany();
                
                $html_arr_mih[3] = array();
        
                foreach($sh_list_arr[3] as $id_sh => $sh_item)
                {
                     $sh_item_titre = "المعلومات المتوفرة عند ".$sh_item->valTitre();
                     unset($gfield);
                     $gfield = new Gfield();
                     $gfield->where("stakeholder_id = $id_sh and parent_module_id=$pm_id and avail = 'Y' $cond_mihwar");
                     $width_th_arr = array("owner_id"=>"48mm", "module_id"=>"48mm", "gfield_cat_id"=>"31mm", "titre"=>"96mm", "id"=>"17mm");
                     list($html_arr_mih[3][$id_sh], $liste_obj, $ids) = showMany($gfield,"gf_status,owner_id,module_id,titre,id",$objme, null, "", "", true, "grid", "tr_1", "tr_2", "tr_0", "ar", "rtl", $sh_item_titre, "bigtitle", $width_th_arr, "240mm",24); // ,gfield_cat_id
                }
        }        

        // mih 4
        if($mih_index[4])
        {
                unset($sh);
        
                $cond_mihwar = "and module_id = 5";
                $sh = new Orgunit();
                
                $sh->where("id in (select distinct stakeholder_id from c0bau.gfield where parent_module_id=$pm_id and avail = 'Y' $cond_mihwar)");
                $sh_list_arr[4] = $sh->loadMany();
                
                $html_arr_mih[4] = array();
        
                foreach($sh_list_arr[4] as $id_sh => $sh_item)
                {
                     $sh_item_titre = "المعلومات المتوفرة عند ".$sh_item->valTitre();
                     unset($gfield);
                     $gfield = new Gfield();
                     $gfield->showId = true;
                     $gfield->where("stakeholder_id = $id_sh and parent_module_id=$pm_id and avail = 'Y' $cond_mihwar");
                     $width_th_arr = array("owner_id"=>"48mm", "module_id"=>"48mm", "gfield_cat_id"=>"31mm", "titre"=>"96mm", "id"=>"17mm");
                     list($html_arr_mih[4][$id_sh], $liste_obj, $ids) = showMany($gfield,"gf_status,owner_id,module_id,titre,id",$objme, null, "", "", true, "grid", "tr_1", "tr_2", "tr_0", "ar", "rtl", $sh_item_titre, "bigtitle", $width_th_arr, "240mm",24); // ,gfield_cat_id
                }
        }
}
else
{
       die("Please Define module");
}



?>
<style type="text/css">
<!--
    .page_header {font-size: 14px;font-family: aealarabiya; width: 100%; border: none; background-color: rgb(228,239,250); color:rgb(63,72,204); border-bottom: solid 1mm rgb(135,184,233); padding: 2mm }
    .page_footer {font-size: 14px;font-family: aealarabiya; width: 100%; border: none; background-color: rgb(228,239,250); color:rgb(63,72,204); border-top: solid 1mm rgb(135,184,233); padding: 2mm}

    .page_garde {font-size: 48px;font-family: aealarabiya; width: 100%; border: none}
    .page_section {font-size: 40px;font-family: helvetica; width: 100%; border: none}
    .page_normal {font-size: 16px;font-family: helvetica; border: none}
    .page_paragraph {font-size: 20px;font-family: helvetica; font-weight:normal; border: none}
    .page_paragraph_title {font-size: 20px;font-family: helvetica; color:#7201B6; font-weight:bold; border: none}
    .highlight_it{font-size: 16px;font-family: helvetica; color:#920126; font-weight:normal; border: none}
    .page_title {font-size: 20px;font-family: helvetica; color:#0172B6; border: none}
    
    .grid{font-size: 14px;font-family: helvetica;width: 240mm; min-width: 240mm; max-width: 240mm;border: solid 1px rgb(38,105,217);background-color: rgb(255,255,255);}
    .tr_0{background-color: rgb(155,155,155); color:rgb(255,255,255);}
    .tr_1{background-color: rgb(234,244,253); text-align: right;}
    .tr_2{background-color: rgb(203,227,250); text-align: right;}
    .bigtitle {background: rgb(38,105,217);    font-size: 18px; font-family: helvetica; color: #ffffff; padding-top: 5px; padding-left:10px;  text-align: center; }
    .grid th {background: rgb(33,145,235);    font: 14px helvetica; color: #ffffff; padding: 10px 5px;  text-align: center; }

-->
</style>
<?
if($mih_index[0])
{
?>
<page>
        <table style="width: 100%;">  
            <tr>
                <td style="width: 100%; text-align: center">
                <img src="../pag/pic/logo.png">
                </td>
            </tr>
            <tr>
                <td style="width: 100%; text-align: center">
                <p class="page_title">إدارة تقنية المعلومات - قسم تحليل وتطوير النظم</p>
                </td>
            </tr>
            <tr class="page_garde">
                <td style="width: 100%; text-align: center">
                <br>
                <br>
                <br>
<?=$parent_doc_name?>       
                </td>
            </tr>
            <tr class="page_normal">
                <td style="width: 100%; text-align: center" align="center">
                        <table cellspacing='0' cellpadding='5px' style="width: 100%;">
                        <tr>
                          <td style="width:5%"></td>
                          <td style="width:90%">
                             <br>
                             <br>
                             <table cellspacing='0' cellpadding='5px' style="width: 100%; border: solid 1px rgb(18,146,110);" dir="rtl">
                                <tr> 
                                    <td style="width: 70%; text-align: center; border-bottom: solid 1px rgb(18,146,110)"><?="رفيق"//$parent_module->getAnalyst()->getDisplay()?> </td>
                                    <td style="width: 30%; text-align: center; border-bottom: solid 1px rgb(18,146,110);background-color: rgb(18,146,110); color:rgb(255,255,255);">المحلل</td>
                                </tr>
                                <tr> 
                                    <td style="width: 70%; text-align: center; border-bottom: solid 1px rgb(18,146,110);background-color: #FEFBE2">1.4</td>
                                    <td style="width: 30%; text-align: center; border-bottom: solid 1px rgb(18,146,110);background-color: #15AC83; color:rgb(255,255,255);">النسخة</td>
                                </tr>
                                <tr> 
                                    <td style="width: 70%; text-align: center; border-bottom: solid 1px rgb(18,146,110)"><?=hijri_current_date("hdate_long")?></td>
                                    <td style="width: 30%; text-align: center; border-bottom: solid 1px rgb(18,146,110);background-color: rgb(18,146,110); color:rgb(255,255,255);">بتاريخ</td>
                                </tr>
                             </table>
                          </td>
                          <td style="width:5%"></td>
                        </tr>
                        <tr>
                          <td style="width:5%"></td>
                          <td style="width:90%">
                             <br>
                             <br>
                             <table cellspacing='0' cellpadding='5px' style="width: 100%; border: solid 1px rgb(18,146,110);" dir="rtl">
                                <tr> 
                                    <td colspan='3' style="width: 30%; text-align: center; border-bottom: solid 1px rgb(18,146,110);background-color: rgb(18,146,110); color:rgb(255,255,255);">بمشاركة</td>
                                </tr>
                             <?
                                        $alt_bg = "style=\"background-color: #FEFBE2;\""; 
                                        $alt_bg_c = "";           
                                        foreach($module_fu_list as $fu_item)
                                        {
                                                $fu_usr =& $fu_item->getUser();
                             
                             ?>
                                <tr <?=$alt_bg_c?>> 
                                    <td style="width: 30%; text-align: center; border-bottom: solid 1px rgb(18,146,110)"><?=$fu_item->valDescription()?></td>
                                    <td style="width: 40%; text-align: center; border-bottom: solid 1px rgb(18,146,110)"><?=$fu_usr->getSempl()->valJob()?></td>
                                    <td style="width: 30%; text-align: center; border-bottom: solid 1px rgb(18,146,110)"><?=$fu_usr->getDisplay()?></td>
                                </tr>
                             <?
                                            if ($alt_bg_c==$alt_bg) $alt_bg_c = ""; else $alt_bg_c=$alt_bg;
                                        }
                             ?>

                             </table>
                          </td>
                          <td style="width:5%"></td>
                        </tr>
                        </table>    
                </td>
            </tr>
        </table>
</page>
<page orientation="paysage" backtop="14mm" backbottom="7mm" backleft="7mm" backright="7mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 32%; text-align: left">
                    المؤسسة العامة للتدريب التقني والمهني       
                </td>
                <td style="width: 68%; text-align: right">
                    <?=$parent_doc_name?>       
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: right">
                    [[page_nb]] من [[page_cu]] الصفحة
                </td>
            </tr>
        </table>
    </page_footer>
    <table style="width: 100%;">
            <tr class="page_section">
                <td style="width: 100%; text-align: center">
                <br>
                 مقدمة       
                <br>
                </td>
            </tr>
            <tr class="page_paragraph">
                <td style="width: 100%; text-align: right">
                <br>
في إطار التعاون بين إدارة التخطيط وإدارة تقنية المعلومات لإنشاء برنامج تقني يخص إدارتي التخطيط والإحصاء ويستمد معلوماته (مدخلات النظام) من منصة ذكاء الأعمال، تمت دراسة توفر المعلومات المطلوبة 
لتحديد مصادرها (الادارة ، النظام ، المسؤول) وهذا التقرير يبين جدول نتائج هذه الدراسة<br>
<br>
<?
        foreach($mih_order_arr as $mih_ord => $mih_k)
        {
          if(count($sh_list_arr[$mih_k])>0)
          {
?>  
   <span class='page_paragraph_title'><?=$mih_trad[$mih_ord+1]?></span><br>
   <?=$mih_desc_html[$mih_k]?> 
<?
          }
        }
?>

                </td>
            </tr>
     </table>
</page>

<?
}


foreach($mih_order_arr as $mih_ord => $mih_k)
{
  if(count($sh_list_arr[$mih_k])>0)
  {
?>



<page pageset="old">
    <table style="width: 100%;">
            <tr class="page_section">
                <td style="width: 100%; text-align: center">
                <br>
                <br>
                <br>
                <br>
                <br>
                        <?=$mih_trad[$mih_ord+1]?>
                <br>
                        <?=$mih_title[$mih_k]?>
                </td>
            </tr>
     </table>       
</page>
<page pageset="old">
<table style="width: 100%;">
<?
        
        foreach($sh_list_arr[$mih_k] as $id_sh => $sh_item)
        {
             foreach($html_arr_mih[$mih_k][$id_sh] as $html)
             {
?>
<tr>
  <td style="width: 5%; text-align: center" align="center"> &nbsp;
  </td>
  <td style="width: 92%; text-align: right; " align="right">
<?
             echo "<br>\n";
             echo $html;
?>
  </td>
  <td style="width: 3%; text-align: center" align="center"> &nbsp;
  </td>
</tr>
<?
            } 
        }
?> 
</table>    
</page>
<?
  }
}
?>
<page pageset="old">
<table style="width: 100%;">
            <tr class="page_section">
                <td style="width: 100%; text-align: center">
                <br>
                <br>
                <br>
                <br>
                 معلومات أخرى مهمة       
                <br>
                </td>
            </tr>
     </table>
</page>
<!-- 
<page pageset="old">
    <table style="width: 100%;">  
            <tr>
                <td style="width: 100%; text-align: center">
                <img src="../pag/pic/doc_needs-stats-<?=$pm_id?>.png">
                </td>
            </tr>
     </table>       
</page>

<page pageset="old">
    <table style="width: 100%;">  
            <tr>
                <td style="width: 100%; text-align: center">
                <img src="../pic/doc_needs-stats-d-<?=$pm_id?>.png">
                </td>
            </tr>
     </table>       
</page>
-->
<page pageset="old">
        <table style="width: 100%;">
            <tr class="page_title">
                <td style="width: 100%; text-align: center">
                <br>
                الأنظمة الجاهزة لتغذية منصة ذكاء الأعمال 
                </td>
            </tr>
<?

        foreach($html_arrA as $html)
        {
?>
<tr>
  <td style="width: 100%; text-align: right; " align="right">
<?
             echo "<br>\n";
             echo $html;
?>
  </td>
</tr>
<?
        } 

?> 
            
     </table>
</page>

<page pageset="old">
        <table style="width: 100%;">
            <tr class="page_title">
                <td style="width: 100%; text-align: center">
                <br>
                المسؤولين على هذه الأنظمة للتواصل 
                </td>
            </tr>
<?
        

        
        foreach($html_arrB as $html)
        {
?>
<tr>
  <td style="width: 100%; text-align: right; " align="right">
<?
             echo "<br>\n";
             echo $html;
?>
  </td>
</tr>
<?
        } 

?> 
            
     </table>
</page>

<page pageset="old">
    <table style="width: 100%;">
            <tr class="page_section">
                <td style="width: 100%; text-align: center">
                <br>
                <br>
                <br>
                <br>
                <br>
                        بحث في مدى معرفة تاريخ تحديث البيانات                
                </td>
            </tr>
     </table>       
</page>

<page pageset="old">
<table style="width: 100%;">
<tr class="page_paragraph">
  <td style="width: 5%; text-align: center" align="center"> &nbsp;
  </td>
  <td style="width: 92%; text-align: right; " align="right"><br>
1.	سيقوم المهندس نبيل بالتواصل مع المهندس عبدالخالق للتفاهم حول هذه النقطة واعطاء كامل التفاصيل<br> 
2.	لكن يمكن القول إجمالا أنه لا يوجد في المنصة حاليا إلا تاريخ (ووقت) استيراد البيانات من قاعدة البيانات الأصلية ولا يوجد تاريخ تحديث المعلومة نفسها في النظام الأصلي.<br>
مع الاشارة أن بعض البيانات هي إحصائيات تعد مجموعة من السجلات قد يكون بعضها محدث والبعض غير محدث وعدم تحديثه قد يكون لتقصير من الموظف كما يمكن أن يكون لأن البيانات نفسها لم تتغير<br>
فتحديد هل هذه الاحصائية محدثة أم لا في الحقيقة يعود لمدى مصداقية وحداثة المعلومات في النظام ككل والموظف مسؤول بدرجة أولى عن القيام بتحديث البيانات التي هو مكلف بها<br> 
3.	بعض البيانات قد تكون تحتاج تحديث أكيد لحساسيتها وخطورتها في صنع القرار ومراقبة تحديثها أمر ضروري ولو اقتضى الأمر اجراء تعديلات في النظام الأصلي لتوفير معلومة آخر تحديث فيجب أن تحدد هوية هذه البيانات الحساسة لينظر فريق المنصة في الأمر ويتخذ الاجراءات اللازمة<br>
4.	لذلك بامكان المهندس عبدالخالق تحديد هذه المعلومات التي تحتاج تحديث أكيد لحساسيتها وخطورتها في صنع القرار وذلك بتصفح تقرير المشروع ثم إعلامنا بها (قائمة معرفات، معرف = الرقم التسلسلي الذي يبدوا في التقرير المرفق)<br>
5.	كل البيانات التي ستأتي من النظام الجديد أقصد "نظام ادخال البيانات الغير المؤتمتة" ستكون فيها تاريخ ووقت آخر تعديل مع الموظف الذي قام بهذا التعديل فلن يكون هنالك مشكل فيها باذن الله<br>
  </td>
  <td style="width: 3%; text-align: center" align="center"> &nbsp;
  </td>
</tr>  
</table>       
</page>





<?php
    $content = ob_get_clean();
    $timestamp_ = date("Y-m-d H:i:s");    
    //echo "here after ob_get_clean".$timestamp_;

    //
    if(isset($_GET['filetxt']))
    {
            require_once "afw_Filesystem.php";
            $path = "C:\\dbg\\";
            $txtfile = $path.'content_pdf.txt';
            $wrt = Filesystem::write($txtfile, $content, 'append');
            if($content and !$wrt) echo "failed to write content to $txtfile (".Filesystem::path($path).")<br>";
            else echo "file written to $txtfile (".Filesystem::path($path).")<br>";
    }
    else
    {
            if($_GET['vuehtml'] and $_GET['vuepag']) include("header.php");
            require_once(dirname(__FILE__).'/../lib/html2pdf/html2pdf.class.php');
            try
            {   
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, $_GET['vuehtml']);
                //echo "here before html2pdf->Output".date("Y-m-d H:i:s");
                $html2pdf->Output("doc_needs_$pm_id.pdf");
                //$html2pdf->Output("${path}doc_needs_${pm_id}_$timestamp_.pdf", 'F');
                //echo "here after html2pdf->Output".date("Y-m-d H:i:s");
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
            if($_GET['vuehtml'] and $_GET['vuepag']) include("footer.php");
    }