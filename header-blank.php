<?php 
$meta = get_field('meta');
$json = get_field('json');
?>

<!DOCTYPE html>
<html data-site-url="http://onlinecasinoprofy.com/" lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#31ce8a">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://ajax.googleapis.com">
    <link rel="preconnect" href="https://www.google-analytics.com">
    <?php 
        if(!empty($meta) && !empty($meta['content']) && $meta['show_in'] == 'head') echo $meta['content'];
        if(!empty($json) && !empty($json['content']) && $json['show_in'] == 'head') echo '<script defer async type="application/json">'.$json['content'].'</script>';
    ?>

    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo IMG_URL; ?>favicon.ico">
    
    <?php 
        wp_head(); 
        getHreflang(); 
        echo stripcslashes(get_option('header')); 
    ?>
</head>
<body>
    <?php 
        if(!empty($meta) && !empty($meta['content']) && $meta['show_in'] == 'body') echo $meta['content'];
        if(!empty($json) && !empty($json['content']) && $json['show_in'] == 'body') echo '<script defer async type="application/json">'.$json['content'].'</script>';
    ?>