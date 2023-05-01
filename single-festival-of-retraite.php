<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1><?php the_title(); ?></h1>
<?php
$url = get_permalink();
if(str_ends_with($url, '/')) {
    $strLen = strlen($url) - 1;
    $url = substr($url, 0, $strLen);
}
$slug = array_pop(explode('/', $url));
$redirect = "https://ecstaticdance.nl/festivals-retraites/";
// $redirect = "https://ecstaticdance.nl/festivals-retraites/?slug=".$slug."&wp=1";
wp_redirect($redirect);
exit;
?>

<?php wp_footer(); ?>
</body>
</html>

