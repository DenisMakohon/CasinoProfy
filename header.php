<?php

if (!session_id()) {
    ini_set('session.use_cookies', 'On');
    ini_set('session.use_trans_sid', 'Off');
    session_set_cookie_params(0, '/');
    session_start();
}

$lang = array(
  'pl' => "pl-PL",
  'ua' => "ru-UA",
  'en_US' => "en",
  'en' => "en",
  'de' => 'de-DE',
  'es' => 'es'
);

$htmlLang = "";
if (isset($lang[$GLOBALS['currentLang']])) {
  $htmlLang = $lang[$GLOBALS['currentLang']];
} else {
  $htmlLang = $GLOBALS['currentLang'];
}
global $post;
$post_slug = '';

$meta = '';
$json = '';
$cod_head = "";
$howToJson = array();
$howToJsonSteps = array();

if($post){
  $post_slug = $post->post_name;

  $meta = get_field('meta');
  $json = get_field('json');
  $howToJson = get_field('howto');
  $howToJsonSteps = get_field('benefits');
  $cod_head = get_field('cod_head');  
}

// $translations_page = $GLOBALS['translations_page'];

$lang_settings = get_option('lang');
if($lang_settings === false) $lang_settings = array('html' => 'en', 'hreflang' => 'en', 'hreflang_title' => '' );

$html_lang = $post_slug == "ihrovi-avtomaty-na-hroshi" ? "ua-UA" : $lang_settings['html'];
$html_lang_post = get_field('html_lang');
if( !empty($html_lang_post) ) $html_lang = $html_lang_post;
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$isBot = isBot();
?>
<!DOCTYPE html>
<html data-site-url="<?= home_url() ?>/" <?php if($isBot): ?> lang="<?=$html_lang?>" <?php endif; ?>>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="theme-color" content="#31ce8a">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="preconnect" href="https://ajax.googleapis.com">
  <link rel="preconnect" href="https://www.google-analytics.com">
  <link rel="preconnect" href="https://www.google.com">
  <link rel="preconnect" href="https://www.gstatic.com" crossorigin>

  <?php
    global $cur_template_file;    
    $GLOBALS['cur_template_file'] = false;
    if($post) $GLOBALS['cur_template_file'] = get_post_meta($post->ID, '_wp_page_template', true);
    if($GLOBALS['cur_template_file'] == 'casinos.php'){
  ?>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <?php } ?>
  
  <script defer async defer async type='text/javascript'>
    var userAg = '<?php echo $userAgent;?>';
  </script>
  <?php
  if (!empty($meta) && !empty($meta['content']) && $meta['show_in'] == 'head') echo $meta['content'];
  if (!empty($json) && !empty($json['content']) && $json['show_in'] == 'head') echo '<script defer async type="application/json">' . $json['content'] . '</script>';
  
  if(isset($howToJson['out']) && !empty($howToJson['out']) && !in_array('',$howToJson)){
    $totalTime = explode(":", $howToJson['totaltime']);

    echo '<script defer async type="application/ld+json">'.
    '{'.
      '"@context": "http://schema.org",'.
      '"@type": "HowTo",'.
      '"name": "'.$howToJson['name'].'",'.
      '"description": "'.$howToJson['description'].'",'.
      '"totalTime": "'."P0DT".$totalTime[0]."H".$totalTime[1]."M".'",'.
      '"supply": ['.
        '{'.
          '"@type": "HowToSupply",'.
          '"name": "'.$howToJson['supply'].'"'.
        '}'.
      '],'.
      '"tool": ['.
        '{'.
          '"@type": "HowToTool",'.
          '"name": "'.$howToJson['howtotool'].'"'.
        '}'.
      '],'.
      '"step": [';

      foreach($howToJsonSteps as $step){
        echo '{'.
          '"@type": "HowToStep",'.
          '"url": "'.$GLOBALS['current_url'].'#'.strtolower(str_replace(" ", "_", $step['title'])).'",'.
          '"name": "'.$step['title'].'",'.
          '"itemListElement": ['.
            '{'.
              '"@type": "HowToDirection",'.
              '"text": "'.$step['text'].'"'.
            '}'.
          '],'.
          '"image": {'.
            '"@type": "ImageObject",'.
            '"url": "'.IMG_URL.'benefits-icon.svg",'.
            '"height": "63",'.
            '"width": "60"'.
          '}'.
        '}';
        if($step != end($howToJsonSteps)) echo ',';
      }
      echo ']}</script>';
  }
  ?>

  <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo IMG_URL; ?>favicon.ico">
  <script defer async type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    <?php
      $recaptcha = get_option('recaptcha');
      if(isset($GLOBALS['recaptcha']['site']) && !empty($GLOBALS['recaptcha']['site'])) {
        echo 'var recaptcha_site = "'.$GLOBALS['recaptcha']['site'].'";';
      }
    ?>
  </script>
  <?php wp_head(); ?>
  <style>
    /* PRELOADER */
    #loader {
      background: #fff;
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      width: 100%;
      height: 100%;
      z-index: 99999999999;
      transition: opacity 0.4s .4s;
      opacity: 1;
      pointer-events: auto;
    }

    #loader.hide {
      opacity: 0;
      pointer-events: none;
    }
  </style>

  <script defer async>
    // PRELOADER
    window.onload = function() {
      // document.getElementById('loader').classList.add('hide');
      var hd = document.getElementsByTagName('head').item(0);
      var js = document.createElement('script');
      js.setAttribute('language', 'javascript');
      js.setAttribute('src', 'https://certify.gpwa.org/script/onlinecasinoprofy.com/');
      hd.appendChild(js);
      return false;
    }
  </script>
  <?php 
    if (!get_option('hreflang_lgsw')) getHreflang();
    echo stripcslashes(get_option('header')); 
    if (!empty($cod_head)) echo $cod_head;
  ?>
</head>

<body class="hide_body ">

  <?php
  $payments = get_option('payment');
  
  if($payments != "payment" && $payments != false) :
  ?>
  <header class="paymentHeader text-center">
    <?php foreach($payments as $payment){ ?>
      <a href="<?=$payment['link']?>"><?=$payment['name']?></a>
    <?php } ?>
  </header>
  <?php 
  endif;
  if (!empty($meta) && !empty($meta['content']) && $meta['show_in'] == 'body') echo $meta['content'];
  if (!empty($json) && !empty($json['content']) && $json['show_in'] == 'body') echo '<script defer async type="application/json">' . $json['content'] . '</script>';

  get_template_part( 'tmp/common/navigation', null );
  
  ?>