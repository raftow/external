<?php
$system_config_arr = [ 
    
    'host' => "localhost",
    'user' => "root",
    'password' => "",
    

    'limesurveyhost' => "127.0.0.1",
    'limesurveyuser' => "root",
    'limesurveypassword' => "",
    

    'main_company_domain' => "assaf.sa",

    'MODE_MEMORY_OPTIMIZE' => false,


    'main_module' => "license",
    'main_module_home_page' => "../crm/index.php",
    'main_module_banner' => "../crm/pic/banner-top-2022.png",
    'customer_module_banner' => "../crm/pic/banner-to-customer.png",

    'simulate_sms_to_mobile' => "0598988330",

    
    'copyright_infos' => false,
    

    'crm_rt_list' => [/*1,*/ 2,3,12,13],
    
    'check_employee_from_external_system' => true,

    'login_page_options' => [
        'register_as' => 'user',  
        'password_reminder' => true,
    ],

    

    'internal_email_domains' => ["assaf.sa"=>true],

    // files upload
    
    'uploads_http_path' => "../pag/uploads",
    
    'uploads_root_path' => "E:\\work\\dev\\hub3.1\\pag\\uploads\\",

    // sis config
    "pctg_limit_to_create_next_school_year" => 60,
    'quick_links_title' => 'قائمة مواقع أخرى',

    'MODE_DEVELOPMENT' => true,

];
date_default_timezone_set ("Asia/Riyadh");