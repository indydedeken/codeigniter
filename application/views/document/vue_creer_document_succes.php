<?php
    echo $upload_data['raw_name'];
?>

<?php if (isset($upload_data)) { ?>
<p>Document uploadé :</p>
<ul>
    <?php
	foreach ($upload_data as $item => $value):
    ?>
    <li><?php echo $item;?>: <?php echo $value;?></li>
    <?php endforeach; ?>
    <?php } ?>
</ul>

<?php
/* Retour d'erreur sur l'upload de document */
if (isset($error)) {
  echo $error; 
}
?>
<p><?php echo anchor('#', 'Upload Another File!'); ?></p>
