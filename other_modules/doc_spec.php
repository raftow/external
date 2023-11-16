<?php
ob_start();
require_once("db.php");
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
/*
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
$mih_trad[6] = "المحور السابع";


$mih_title[1] = "المدخلات التي ليست في منصة الذكاء ولكنها مؤتمتة";
$mih_title[2] = "المدخلات الغير مؤتمتة مع معرفة مصدرها وبالتالي هي موضوع إنشاء نظام حافظة المؤسسة المقترح";
$mih_title[3] = "المعلومات الغير موجودة في المنصة وجار التأكد من وجود أنظمة لها";
$mih_title[4] = "المدخلات المتوفرة في منصة الذكاء";
$mih_title[5] = "5555555555555555";
$mih_title[6] = "6666666666666666";
$mih_title[7] = "77777777777777777";


$mih_desc_html[1] = "يبين قائمة المعلومات التي تم تحديد الأنظمة التي تتعامل بها وليست بعد في منصة الذكاء ليبدأ فريق منصة الذكاء العمل عليها من أجل توفيرها بشكل مناسب  للمستخدم<br>
ملاحظة مهمة : بعض الأنظمة المشار إليها سابقا لا تزال تحت الدراسة والتطوير فلا يمكن حاليا الربط معها حتى تستقر هذه الأنظمة على نسخة متينة وتوضع في طور الإنتاج ويتم التعرف عليها بوجود بين قوسين في طور الدارسة أو في طور التطوير أو في طور التجربة وهذا يعني أن فريق المنصة ينتظر الضوء الأخضر قبل بدء الربط معها<br>";

$mih_desc_html[2] = "يبين قائمة المعلومات التي هي ليست في منصة الذكاء ولا يوجد نظام ممكن أن تستخرج منه آليا ولكنها معلومة عند الإدارة التي تملكها فيجب أن يتم إدخالها يدويا في نظام خاص. ونحن بصدد دراسة فكرة تطوير نظام نقترح له الاسم التالي [نظام حافظة المؤسسة لادخال البيانات الغير المؤتمتة] وسيقوم المهندس رفيق بكتابة مستند يشرح الفكرة العامة لهذا النظام لكي يتم اعتماده من طرف مدير ادارة التخطيط و الميزانية ثم إعتماده من طرف مدير تقنية المعلومات ثم اعتماد الادارة العليا ليبدأ تحليل المشروع ";

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
*/

  
if($pm_id)
{
        require_once "module.php";
        $parent_module = new Module();
        $parent_module->load($pm_id);
        $parent_module_name = $parent_module->valTitre();
        $parent_doc_name = "مواصفات ".$parent_module_name;
        $parent_sh = $parent_module->getMainSH();
        $parent_sh_id = $parent_sh->getId();
        if(!$parent_sh_id) 
        {
                $out_scr = "Please Define Main SH for this module $pm_id";
                exit;
        }

        require_once "module_auser.php";
        // chercher les participants au projet (FU)
        $module_fu = new ModuleAuser();
        $module_fu->select("id_module",$pm_id);
        //$module_fu->where("arole_mfk like '%,1,%'");
        $module_fu->select("avail",'Y');
        $module_fu_list = $module_fu->loadMany();

                
        require_once "ptext.php";
        
        $mainDoc = new Ptext();
        $mainDoc->select("module_id",$pm_id);
        $mainDoc->select("ptext_type_id",5);
        $mainDoc->select("ptext_cat_id",8);
        
        if(!$mainDoc->load())
        {
             $out_scr = "Please define main document for this module $pm_id (متطلبات $parent_module_name)";
             exit;
        }
        
        $doc_id =  $mainDoc->getId();
        
        // mihwar
        $sectionDoc = new Ptext();
        $sectionDoc->select("module_id",$pm_id);
        $sectionDoc->select("ptext_type_id",6);
        $sectionDoc->select("ptext_cat_id",9);
        $sectionDoc->select("pdocument_id",$doc_id);
        
        if(!$sectionDoc->load())
        {
              $out_scr = "Please define main definition section for this module $pm_id (تعريف $parent_module_name)";
              exit; 
        }
        
        $section_id = $sectionDoc->getId();

        if(!$doc_id or !$section_id)
        {
             $out_scr = "Please define main document and main definition section for this module $pm_id (تعريف $parent_module_name)";
             exit;    
        }
        
        // -- require_once "auser.php";
        $ques_l = new Ptext();
        $ques_l->select("module_id",$pm_id);
        $ques_l->select("stakeholder_id",$parent_sh_id);
        $ques_l->select("pdocument_id",$doc_id);
        $ques_l->select("parent_ptext_id",$section_id);
        $ques_l->select("ptext_type_id",3);
        $ques_l->select("ptext_cat_id",4);
        $ques_l->select_visibilite_horizontale();
        $questions_all = $ques_l->loadMany();
        $recur = true;
        if($recur)
        {
                $keys_details = array_keys($questions_all);
                foreach($keys_details as $question_id) 
                {
                      $questions_all[$question_id]->loadDetails(true);
                      //die(var_export($questions_all[$question_id],true));  
                }
        }
        
                
        $html_doc = Ptext::genereDoc($questions_all); //$md,"id_pm,id_main_sh,id_module_status,titre",$objme, null, "", "", true, "grid", "tr_1", "tr_2", "tr_0", "ar", "rtl", "بيانات الأنظمة المهمة لهذا المشروع", "bigtitle", $width_th_arr, "275mm",24);
        
        
                

}
else
{
       die("Please Define module");
}
include "doc_css.php";
?>

<page>
        <table style="width: 100%;">  
            <tr>
                <td style="width: 100%; text-align: center">
                <img src="pic/logo-<?=$parent_sh_id?>.png">
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
                                    <td style="width: 70%; text-align: center; border-bottom: solid 1px rgb(18,146,110)"><?=$parent_module->getAnalyst()->getDisplay()?> </td>
                                    <td style="width: 30%; text-align: center; border-bottom: solid 1px rgb(18,146,110);background-color: rgb(18,146,110); color:rgb(255,255,255);">المحلل</td>
                                </tr>
                                <tr> 
                                    <td style="width: 70%; text-align: center; border-bottom: solid 1px rgb(18,146,110);background-color: #FEFBE2">1.0</td>
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
                                    <td style="width: 40%; text-align: center; border-bottom: solid 1px rgb(18,146,110)"><?=$fu_usr->valJob()?></td>
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
<page backtop="14mm" backbottom="7mm" backleft="7mm" backright="7mm" pagegroup="new">
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 32%; text-align: left">
                    <?=$parent_sh->getDisplay()?>       
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
                 المتطلبات       
                <br>
                </td>
            </tr>
     </table>
<?
 echo $html_doc;
?>
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
            if(isset($_GET['vuehtml'])) include("header.php");
            require_once(dirname(__FILE__).'/../lib/html2pdf/html2pdf.class.php');
            try
            {   
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                //echo "here before html2pdf->Output".date("Y-m-d H:i:s");
                $today = date("Y-m-d");
                $html2pdf->Output("doc_spec_${pm_id}_$today.pdf");
                //$html2pdf->Output("${path}doc_needs_${pm_id}_$timestamp_.pdf", 'F');
                //echo "here after html2pdf->Output".date("Y-m-d H:i:s");
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
            if(isset($_GET['vuehtml'])) include("footer.php");
    }