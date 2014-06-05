<?php
	/*
	* Cette vue permet d'afficher l'ensemble
	* de la bibliothèque personnelle d'un utilisateur.
	* Cette vue est chargée via ajax.
	* Cette vue permet la suppression d'un document.
	*
	*/

	if (isset($files) && count($files))
	{
?>
    
    <form id="files_uploaded" class="well-white well-large">
        <h3>Les documents uploadés</h3>
        <div id="accordion" class="panel-group">
            <?php
            //var_dump($files);
            $sizeMax = 80;
			
		   	foreach ($files as $file)
            {
                $titre = (strlen($file->titre)>$sizeMax ? substr($file->titre, 0, $sizeMax)."..." : $file->titre)
                ?>
                  <div class="panel panel-default" id="element<?=$file->id?>">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$file->id?>">
                          <?=$titre?>.pdf
                        </a>
                      </h4>
                    </div>
                    <div id="collapse<?=$file->id?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="<?=base_url()?>document/afficher/<?=$file->id?>" class="list-group-item">Accéder au document</a>
                                <a href="#" class="list-group-item">Modifier les informations</a>
                                <a class="list-group-item list-group-item-danger lien_suppression_document" data-file_id="<?=$file->id?>">Supprimer le document</a>
                            </div>
                        </div>
                    </div>
                  </div>
                <?php
            }
            ?>
        </div>
    </form>
<?php
	}
	else
	{
?>
    <p>Aucun fichier ici :'(</p>
<?php
	}
?>