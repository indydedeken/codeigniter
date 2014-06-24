<div class="container"> <br>
	<br>
	<div class="annonce">
		<div class="col col-sm-4 col-md-3">
			<h1>Création de groupe</h1>
		</div>
		<div class="justify col-sm-8 col-md-9">
			
			<?php echo form_open('groupe/creation', 'id="creationGroupe" class="form-horizontal" role="form"')?>
				<div class="form-group">
					<label class="col-md-3 control-label">Nom du groupe</label>
					<div class="col-md-9">
						<input id="nom" type="text" name="nom" class="form-control" placeholder="Nom du groupe">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Description</label>
					<div class="col-md-9">
						<textarea name="description" style="max-width:100%;" class="form-control" placeholder="Qui dois-rejoindre le groupe ? Quel est son but ?"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Document à ajouter </label>
					<div id="listeGroupe" class="col-md-9"> 
						<!-- Panier des documents à ajouter -->
						<div class="ui-widget ui-helper-clearfix">
							
							<div id="trash" class="ui-widget-content ui-state-default">
								<h5>&nbsp;Glisser-déposer les documents</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-0 col-sm-12">
						<button type="submit" class="btn btn-lg btn-success" style="width:100%;">Créer mon groupe !</button>
					</div>
				</div>
			</form>
			
			<!-- Affichage des documents -->
			<!-- La bibliothèque est hors formulaire pour ne pas valider les input["type=hidden"] -->
			<div id="listeDocs">
				<h3>Documents disponibles :</h3>
				
					
					<?php 
					if($documents->num_rows() == 0)
					{
					?>
                    	<p style="float:right;">Vous n'avez pas encore chargé de documents ici ! Allez-y !
                        <br>
                        <a class="btn btn-default right" href="<?=base_url().'document/creer';?>">Upload</a>
                        </p>
                    <?php 
					}
					else 
					{
						?>
                        <ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
                        <?php
						foreach($documents->result() as $item) { ?>
							<li class="ui-widget-content ui-corner-tr" data-id="<?=$item->id?>" data-titre="<?=$item->titre?>">
								<h5 class="ui-widget-header">
								<?php 
									if(strlen($item->titre)>50)
										echo substr($item->titre, 0, 50) . '...';
									else
										echo $item->titre;
									echo " <br>-<br> " . $item->auteur;
									?>
								</h5>
							</li>
						<?php 
						} 
						?>
                        </ul>
						<?php
					}
					?>
					
				
			</div><!-- ./affichage des documents --> 
		
	</div>
</div>
<script>
$(function() {
	 $(function() {
	// there's the gallery and the trash
	var $gallery = $( "#gallery" ),
	$trash = $( "#trash" );
	// let the gallery items be draggable
	$( "li", $gallery ).draggable({
		cancel: "a.ui-icon", // clicking an icon won't initiate dragging
		revert: "invalid", // when not dropped, the item will revert back to its initial position
		containment: "document",
		helper: "clone",
		cursor: "move"
	});
	// let the trash be droppable, accepting the gallery items
	$trash.droppable({
		accept: "#gallery > li",
		activeClass: "ui-state-highlight",
		drop: function( event, ui ) {
			deleteImage( ui.draggable );
		}
	});
	// let the gallery be droppable as well, accepting items from the trash
	$gallery.droppable({
		accept: "#trash li",
		activeClass: "custom-state-active",
		drop: function( event, ui ) {
			recycleImage( ui.draggable );
		}
	});
	// image deletion function
	var recycle_icon = "<a href='link/to/recycle/script/when/we/have/js/off' title='Retirer le document' class='ui-icon ui-icon-refresh'>Retirer le document</a>";
	function deleteImage( $item ) {
		$item.fadeOut(function() {
			var $idDocument = $item.attr('data-id');
			var $list = $( "ul", $trash ).length ?
			$( "ul", $trash ) :
				$( "<ul class='gallery ui-helper-reset'/>" ).appendTo( $trash );
			$item.find( "span.temp" ).remove();
			$item.append('<span class="temp">'+$item.attr('data-titre').substr(0, 10)+'...</span>');
			$item.find( "input#doc_" + $idDocument ).remove();
			$item.append('<input type="hidden" id="doc_' + $idDocument + '" name="documents[]" value="' + $idDocument + '" />')
			$item.append( recycle_icon ).appendTo( $list ).fadeIn(function() {
				$item
				.animate({ width: "150px" });
			});
		});
	}
	function recycleImage( $item ) {
		$item.fadeOut(function() {
			$item.find( "span.temp" ).remove();
			$item
			.find( "a.ui-icon-refresh" )
			.remove()
			.end()
			.css( "width", "180px")
			/*.append( trash_icon )*/
			.find( "img" )
			.css( "height", "95px" )
			.end()
			.appendTo( $gallery )
			.fadeIn();
		});
	}
	// image preview function, demonstrating the ui.dialog used as a modal window
	/*function viewLargerImage( $link ) {
		var src = $link.attr( "href" ),
		title = $link.siblings( "img" ).attr( "alt" ),
		$modal = $( "img[src$='" + src + "']" );
		if ( $modal.length ) {
			$modal.dialog( "open" );
		} else {
			var img = $( "<img alt='" + title + "' width='384' height='288' style='display: none; padding: 8px;' />" )
			.attr( "src", src ).appendTo( "body" );
			setTimeout(function() {
				img.dialog({
				title: title,
				width: 400,
				modal: true
				});
			}, 1 );
		}
	}*/
	// resolve the icons behavior with event delegation
	$( "ul.gallery > li" ).click(function( event ) {
		var $item = $( this ),
		$target = $( event.target );
		if ( $target.is( "a.ui-icon-trash" ) ) {
			deleteImage( $item );
		} else if ( $target.is( "a.ui-icon-zoomin" ) ) {
			viewLargerImage( $target );
		} else if ( $target.is( "a.ui-icon-refresh" ) ) {
			recycleImage( $item );
		}
		return false;
		});
	});
});
</script> 
<script type="application/javascript"><!--
	$(document).ready(function() {
		$('#creationGroupe').submit(function(e){
			
			if($('#creationGroupe #nom').val() == '') {
				generateError('Votre groupe ne porte pas de nom.');
				return false;
			} else 
				return true;
		});
	});
--></script> 
<script type="application/javascript">
	/*
	 * Préparation des boites de notification
	 * generateAlert()
	 * generateSuccess()
	 * generateError()
	 */
	 
	//
	function generateAlert(msg) {
		var n = noty({
			text        : msg,
			type        : 'alert',
			dismissQueue: true,
			layout      : 'top',
			theme       : 'defaultTheme',
			killer		: true,
			maxVisible	: 1,
			timeout		: 3000,
			callback: {
				onShow: function() {},
				afterShow: function() {},
				onClose: function() {},
				afterClose: function() {$('#nom').focus();}
			}	
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
			layout      : 'top',
			theme       : 'defaultTheme',
			killer		: true,
			maxVisible	: 1,
			timeout		: 3000,
			callback: {
				onShow: function() {$('#nom').focus();},
				afterShow: function() {},
				onClose: function() {$('#nom').focus();},
				afterClose: function() {}
			}	
		});
	}
</script>
