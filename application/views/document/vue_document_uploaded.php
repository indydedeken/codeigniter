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
        <ul>
            <?php
            //var_dump($files);
            $sizeMax = 80;
            
            foreach ($files as $file)
            {
                $titre = (strlen($file->titre)>$sizeMax ? substr($file->titre, 0, $sizeMax)."..." : $file->titre)
                
                ?>
                <div id="<?=$file->id?>" class="btn-group">
                    <br>
                    <button class="btn btn-info texte"><b><?=$titre?>.pdf</b><br><i><?=$file->auteur?></i></button>
                    <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?=base_url()?>document/afficher/<?=$file->id?>">
                            Accéder au document
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Modifier les informations
                            </a>
                        </li>
                        <li>
                            <a class="lien_suppression_document" data-file_id="<?=$file->id?>">
                                Supprimer le document
                            </a>
                        </li>
                    </ul>
                </div>
                <?php
            }
            ?>
        </ul>
        
    </form>
    
    <?php
}
else
{
    ?>
    <p>No Files Uploaded</p>
    <?php
}
?>