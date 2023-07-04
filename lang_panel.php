<?php
/*
*  get example of use here http://aekap.c-europe.eu/lang_panel/miltilinual_php_app_with_text_db.rar
*
*
*/
////// constants //////////////////////
define('PATH_TO_LANGUAGES' ,            'languages');
define('PATH_TO_FLAGS'     , 'assets/images/flags/');
define('DB_FILES_EXTENSION',                 '.txt');
// the following constants use for easy use language name with or without commas
define('en','en');    //English
define('ru','ru');    //Русский
define('ee','ee');    //эстонская
define ('lv','lv');   //латвийский
define ('lt','lt');   //литовский
define('md','md');    //молдавская
define('ua','ua');    // Украинская
define ('by','by');   //беларуский
define ('ge','ge');   //грузинский
define ('ar','ar');   //
define ('az','az');   //
define ('kr','kr');   //киргизская
define('uz','uz');    // узбекская
define('kz','kz');    //казахская
define ('td','td');   // таджикская
define ('tm','tm');   // туркменская
define('gr','gr');    // татарский
define('cz','cz');    // Cesky
define('de','de');    // German
define('it','it');    // Italian
define('fr','fr');    // France
define('tj','tj');    // Tajik
define('tu','tu');    // Australian English
define('jp','jp');    // Japan
define('vn','vn');    // Vietnam
define("cn",'cn');    // China
define("es",'es');    // Español
define("pt",'pt');    // Português
define("ro",'ro');    // Romanian
define("pl",'pl');    // Romanian

 
//--------------const default-------------------------------|
define ('DEFAULT_LANG',    en);

/////////  GLOBALS /////////////////////////////////////////////
$langs= array(en, ru, cz, ee, lv, lt, md,ua, by,gr, ar, az, kr, ge, lt, uz, it, jp, cn,tj,fr, vn,  es, pt);          
$lang_title=array(
                   ua => 'український',
                   ar => 'Armenian',
                   gr => 'Greece',
                   az => 'Azerbajan',
                   lt => 'lietuvių',
                   lv => 'latviski',
                   uz => "o'zbek",
                   ru => 'Русский',
                   ge => 'ქართული',
                   by => 'беларуская',
                   en => 'English',
                   de => 'Deutch',
                   cn => '中國人',
                   cz => 'Česky',
                   ee => 'eesti keel',
                   it => 'Italian',
                   fr => 'France',
                   jp => '日本',
                   vn => 'Tiếng Việt',
                   tu => 'Türkmenler',
                   tj => 'Tоҷикӣ',
                   kz => 'Қазақша',
                   md => 'moldovenesc',
                   ro => 'Romanian',
                   es => 'Español',
                   pt => 'Português',
                   pl => 'Polski',
                   kr => '한국인' ,
                   en => 'English'
 );
 ///////////// functions /////////////////////////////////
 // The labels are in the files with name  "en.txt" , "cz.txt",... and so on. 
function  get_labels(){
  GLOBAL $lng;                     // get access to the global var $lng
  $ret=[];                         // here we will store the result 
  $path_ = PATH_TO_LANGUAGES.DIRECTORY_SEPARATOR.$lng.".txt";
  $r_ = (file_exists($path_))?file($path_):file(PATH_TO_LANGUAGES.DIRECTORY_SEPARATOR."en.txt"); // read the label file 

    foreach($r_ as $key=>$value) {                  
      $ret[$key] = trim($value);                                // clear from unused symbols     
      array_unshift($ret, "[".$lng. "]");                       // insert the string to harmonize the number of string (in the db editor) with the index of approptiated variable in the code for easy human reading the content of db     
    }
  return $ret; 
}
// when trigger this function you can use other arguments in array \$args for use it in other scripts 
function create_request($args=[]){
  GLOBAL $lng;
  $ret ="?lng=" . $lng;
  	if (!is_array($args)) echo("<div class=\"err_mess\" Error in " . basename(__file__) ." l. " . _LINE_ . ": incorrect data type in \$args</div>");	
  	foreach($args as $key=>$value){
  	$ret .= "&".$key."=".$value;
  	}
  return $ret;    
}
//-------------- automatically create needed for translate file
function check_available_lang($f){
  GLOBAL $lng, $lang_title;
  if(!file_exists($f)) {
      $ff = PATH_TO_LANGUAGES . DIRECTORY_SEPARATOR . DEFAULT_LANG. DB_FILES_EXTENSION;
      
      $t  = copy($ff, $f);
      $tf = copy('readme/ReadMe_en.txt', 'readme/ReadMe_' . $lng . '.txt' );
      if($t){
        echo ("<div class = 'success'><h2>Warning!</h2> New file <strong> $f </strong> for ". strtoupper($lang_title[$lng]) . " language is created. <br> Please translate it from " . $lang_title[DEFAULT_LANG] . " language.</div>");
      }else{
        echo("<div class = 'warning'>Something wrong!<br> Can not create the file<strong> " . $f . ".</strong></div>" );
      }
      if($tf){
        echo ("<div class = 'success'><h2>Warning!</h2> New file <strong> 'readme/ReadMe_ $lng .txt'  </strong> for ". strtoupper($lang_title[$lng]) . " language is created. <br> Please translate it from " . $lang_title[DEFAULT_LANG] . " language.</div>");
      }else{
        echo("<div class = 'warning'>Something wrong!<br> Can not create the file<strong> " . $f . ".</strong></div>" );
      }
  }
}
//----------- automatically create the ReadMe_lng.txt 

/* use this code if there are a most of mistakes
$lng     =  DEFAULT_LANG;                            // select default language    
                                                     // check the cookie if we have saved lng in the cookie
if(array_key_exists(('lng', $_COOKIE){
  if(sizeof(array_intersect($langs, $_COOKIE))==1){  // test on errors
    $lng= $_COOKIE['lng'];                           // if all is ok change the language to language saved in Cookie
  } else {
    echo("Something wrong! Check the languages names array and Cookie");
  }
} 
//---------------------------------------------------                                                      // check the request if lng is changed?
if(array_key_exists(('lng', $_REQUEST){
  if(sizeof(array_intersect($langs, $_REQUEST))==1){ //test on errors
    $lng= $_REQUEST['lng'];                          // if all is ok change the language to language sent in \$_REQUEST
  } else {
    echo("Something wrong! Check the languages names in array and in \$_REQUEST");
  }
}  
*/

//----  easy code (without testing of errors) as an alternative of rows before from 58 up to 74 
$lng    = (array_key_exists('lng' , $_REQUEST))? $_REQUEST['lng']:DEFAULT_LANG; 
$labels = get_labels();

//---------------- create the language panel
$lang_panel ='<div style="margin-top:0px">';
if(array_key_exists("show_lang_panel",$_REQUEST)) {   //check if flag was clicked firts time
 foreach($langs as $key=>$value){                     // if so - show language panel with enabled flags (languages) 
    $lang_panel .=  '<a href="?lng='.$value.'"><img src="assets/images/flags/'.$value.'.png" class="flags"   title ="' .
           $lang_title[$value].'"></a>&nbsp;';
    }
 } else{
  $lang_panel.='<a href="?lng='. $lng .'&amp;show_lang_panel=1">
          <img src="' . PATH_TO_FLAGS . $lng.'.png" class="flags"  title ="Current language is ' .$lang_title[$lng].'. ' . $labels[1] .'   ">
       </a>';
 }
 $lang_panel .='</div>';    

 ?>



