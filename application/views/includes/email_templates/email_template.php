<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Pixel Lab</title>
    </head>
    <body style="margin:0;padding:0">
        <div style="max-width:800px;margin:auto;border-radius:10px 10px 0 0;overflow:hidden;border:1px solid black;padding:20px 20px 0;">
            <div style="background:black;text-align:center; margin:-20px -20px 20px; padding:8px 0; line-height:0;">
                <!--<img src="<?php echo base_url('uploads/site/pic/'.SITE_LOGO); ?>" alt="<?php echo SITE_NAME; ?>" />-->
            </div>
            <h2 style="text-align:center; font-family:tahoma; font-weight:normal;"><?php echo $title; ?></h2>
            <h3 style="font-family:tahoma;">Hi <?php echo $receiver_name; ?>!</h3>
            <?php if ($welcome_content <> '' && $welcome_content <> 0) { ?>
                <p style="font-family:tahoma; font-size:14px; text-align:justify; line-height:1.5;">
                    <?php echo $welcome_content; ?>
                </p>
            <?php } ?>
            <?php echo str_replace('[SITE_NAME]', SITE_NAME ,str_replace('[SITE_URL]', base_url(), $email_content)); ?>
            <div style="margin:20px -20px 0; border-top:1px solid #000; padding:10px 10px 0; font-family:tahoma; text-align:center; font-size:12px;">
                <?php echo $footer ?>
            </div>
        </div>
    </body>
</html>