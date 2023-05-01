<?php /* Template Name: Redirect */ ?>
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
$redirect = "https://ecstaticdance.nl/?wp=1";
wp_redirect($redirect);
exit;
?>

<?php wp_footer(); ?>
</body>
</html>

