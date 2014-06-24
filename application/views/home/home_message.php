<div class="container">
    <!--<p class="lead">Un dicton ici, ça fait beau. Surtout sur la page : "<?=$nav?>"</p>--> 
    <!--<blockquote>
    <p>Les citations donnent l'air d'être intelligent.</p>
    <small>Quelqu'un d'inconnu à <cite>Évry</cite></small> </blockquote>-->
    <br>
    <br>
    <div id="aboutUs" class="row annonce alert alert-dismissable">
	 <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="top:-10px;left:-10px;position:relative;z-index:1;">&times;</button>
    <div class="col col-sm-3 col-md-4">
	<h1>À la une</h1>
    </div>
    <div class="justify col-sm-8 col-md-8">
	<span>Markus convertit vos documents PDF en HTML5</span><br>
	Ainsi, vos documents peuvent être partagés et annotés avec vos collaborateurs dans notres web app. <br><br>
	<div class="center">
	    <button class="btn btn-success btn-lg" type="button">Parlez-en</button>
	</div>
	<br><br>
    </div>
</div>
<?php
	if($logged) 
	{
?>
    <div id="finDePage" class="row annonce">
        <div class="col col-sm-3 col-md-4">
        <h1>Activité des groupes</h1>
        </div>
        <div class="justify col-sm-8 col-md-8">
        <?php
        $datePrec = NULL;
        
        if(empty($annotationGrp))
        {	
            echo "Aucune activité ces derniers temps...";
        }
    
        if(isset($annotationGrp))
          foreach($annotationGrp as $annotation)
          {
              
              if($datePrec != $annotation->dateCreation)
              {
              if(substr($annotation->dateCreation, 5, -3) == "06")
              {
                  $mois = 'juin';
              }
              else {
                  $mois = 'juillet';
              }
              ?>
              <i>
                  <strong>
                  ––– Le <?=substr($annotation->dateCreation, 8)?> <?=$mois?>
                  </strong>
              </i>
              <br>
              <?php
              }
              
              if($annotation->idTypeAnnotation == 1)
              {
              $action = 'commenter';
              }
              else if($annotation->idTypeAnnotation == 2)
              {
              $action = 'surligner';
              }
              ?>
              
              <a class="lienGroupe" href="<?=site_url()."document/afficher/".$annotation->idDocument."/groupe/".$annotation->idGroupe?>"><?=$annotation->intitule?></a> - <strong><?=$annotation->emailUtilisateur?></strong> à <?=$action?> le document "<u><?=$annotation->titre?></u>"<br>
              
              <?php
              
              $datePrec = $annotation->dateCreation;
          
          }
        ?>
        <br>
        </div>
    </div>
<?php
	}
?>
<script>

    $(".close").click(function() {
	$('#aboutUs').remove();
    });

    // Détection du support
    if(typeof localStorage!='undefined') {
	// au clic sur le lien
	$(".close").on('click', function() {
	    localStorage.setItem('AboutUs', 'hide');
	    return false;
	});
	
	// si l'utilisateur a choisi de masquer la pub
	if(localStorage.getItem('AboutUs') != undefined) {
	    var AboutUs = localStorage.getItem('AboutUs');
	    // si on ne veut plus voir la pub
	    if(AboutUs == 'hide') {
		    $('#aboutUs').remove();
	    }
	}
	
    } else {
		alert("localStorage n'est pas supporté");
    }
</script>
<script type="application/javascript">
	/*
	 * Préparation des boites de notification
	 * generateAlert()
	 * generateSuccess()
	 * generateError()
	 */
	function generateAlert(msg) {
		var n = noty({
			text        : msg,
			type        : 'alert',
			dismissQueue: true,
			layout      : 'topCenter',
			theme       : 'defaultTheme',
			closeWith	: ['click'],
			maxVisible	: 3,
			timeout		: 7000
		});
	}
	function generateSuccess(msg) {
		var n = noty({
			text        : msg,
			type        : 'success',
			dismissQueue: true,
			layout      : 'topCenter',
			theme       : 'defaultTheme',
			closeWith	: ['click'],
			maxVisible	: 3,
			timeout		: 3000
		});
	}
	//
	function generateError(msg) {
		var n = noty({
			text        : msg,
			type        : 'warning',
			dismissQueue: true,
			layout      : 'topCenter',
			theme       : 'defaultTheme',
			closeWith	: ['click'],
			maxVisible	: 3,
			timeout		: 2500
		});
	}
</script>
