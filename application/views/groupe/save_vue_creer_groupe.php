<div class="container"> <br>
  <br>
  <div id="" class="annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Création de groupe</h1>
    </div>
    <div class="justify col-sm-8 col-md-9">
      <div class="">
      <form id="creationGroupe" class="form-horizontal" role="form">
        <div class="form-group">
          <label for="inputEmail3" class="col-md-3 control-label">Nom du groupe</label>
          <div class="col-md-9">
            <input type="email" class="form-control" placeholder="Nom du groupe">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Description</label>
          <div class="col-md-9">
            <textarea style="max-width:100%;" class="form-control" placeholder="Qui dois-rejoindre le groupe ? Quel est son but ?"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Document à ajouter </label>
          <div id="listeGroupe" class="col-md-9"> 
            <!-- Panier des documents à ajouter -->
            <ol class="form-control">
              <li class="placeholder">Déplacer les documents ici</li>
            </ol>
          </div>
          
          <!-- Affichage des documents -->
         
          <!-- ./affichage des documents --> 
        </div>
        </div>
        <div class="form-group">
			<div class="col-sm-offset-0 col-sm-10">
				<button type="submit" class="btn btn-lg btn-success" style="width:100%;">Créer mon groupe !</button>
			</div>
        </div>
      </form>
      <div id="listeDocs">
        <h3>Donde Esta La Biblioteca</h3>
        <div id="listeDocs">
          <div>
            <ul>
              <?php 
			foreach($documents->result() as $item) { ?>
              <li>
                <?=$item->titre . " - " . $item->auteur?>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function() {
	$( "#listeDocs li" ).draggable({
		appendTo: "body",
		helper: "clone"
	});
	$( "#listeGroupe ol" ).droppable({
		activeClass: "ui-state-default",
		hoverClass: "ui-state-hover",
		accept: ":not(.ui-sortable-helper)",
		drop: function( event, ui ) {
			$( this ).find( ".placeholder" ).remove();
			$( "<li></li>" ).text( ui.draggable.text() ).appendTo( this );
		}
	}).sortable({
		items: "li:not(.placeholder)",
		sort: function() {
			// gets added unintentionally by droppable interacting with sortable
			// using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
			$( this ).removeClass( "ui-state-default" );
		}
	});
});
</script> 
<script type="application/javascript"><!--
	$(document).ready(function() {
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
			layout      : 'topCenter',
			theme       : 'defaultTheme',
			closeWith	: ['click'],
			maxVisible	: 3,
			timeout		: 10000
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
			timeout		: false
		});
	}
</script>