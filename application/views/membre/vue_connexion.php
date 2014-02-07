<!-- vue de la page de connexon -->
<div class="" id="loginModal">
    <div class="modal-header">
      <h2 class="form-signin-heading">Willkommen !</h2>
    </div>
    <div class="panneau-connexion">
      <div class="well">
      	<!-- onglet signin / register -->
        <ul class="nav nav-tabs">
          <li class="<?php if($this->uri->segment(2)=='signin') echo 'active'?>">
          	<a href="#login" data-toggle="tab">Signin</a>
          </li>
          <li class="<?php if($this->uri->segment(2)=='register') echo 'active'?>">
          	<a href="#create" data-toggle="tab">Register</a>
          </li>
        </ul>
		<div id="myTabContent" class="tab-content">
<!--
   -
   -	Formulaire de connexion
   - 
   -
-->  
          <div class="tab-pane <?php if($this->uri->segment(2)=='signin') echo 'active in'; else echo "fade"?>" id="login">
            <?php echo form_open('membre/signin', 'id="signin" class="form-signin" role="form"')?>
              <fieldset>
                  <div id="legend">
                      <legend class="text-muted">Saisir vos identifiants</legend>
                  </div>
                  <?php echo form_error('email', '<span class="label label-warning">','</span><br/>'); ?>
                  <?php echo form_error('mdp', '<span class="label label-warning">','</span><br/>'); ?>
                  <?php if(isset($error)):echo $error;endif;?>
                  <input id="email" name="email" type="email" autofocus placeholder="Email" class="form-control" value="<?php echo set_value('email'); ?>">
                  <input id="mdp" name="mdp" type="password" placeholder="Password" class="form-control">
                  <!-- <label class="checkbox">
                          <input type="checkbox" value="rester-connecter"> Se souvenir de moi
                        </label>-->
                  <?php echo form_submit('', 'Valider', 'class="btn btn-lg btn-success btn-block"')?>
                  <?php //echo anchor('membre/register', 'S\'inscrire', 'class="btn btn-large btn-default btn-block"')?>
                </fieldset>
              <?php echo form_close()?>
          </div>
          
<!--
   -
   -	Formulaire d'inscription
   - 
   -
-->
          <div class="tab-pane fade <?php if($this->uri->segment(2)=='register')echo 'active in'; else echo "fade"?>" id="create">
            <?php echo form_open('membre/register', 'id="register" class="form-horizontal form-register" role="form"')?>
              <fieldset>
                <div id="legend">
                	<legend class="text-muted">Inscription aux services Marküs</legend>
                </div>
                <?php echo form_error('passwordInscription1', '<span class="label label-warning">','</span><br/>'); ?>
                <?php echo form_error('passwordInscription2', '<span class="label label-warning">','</span><br/>'); ?>
                <?php echo form_error('mailInscription', '<span class="label label-warning">','</span><br/>'); ?>
                <?php echo form_error('nomInscription', '<span class="label label-warning">','</span><br/>'); ?>
                <?php echo form_error('prenomInscription', '<span class="label label-warning">','</span><br/>'); ?>
                <!-- nom prenom -->
                <div class="control-group clear">
                    <label for="nomInscription" class="col-md-5 control-label">Nom <em>*</em></label>
                    <div class="col-md-5 groupe">
                        <input type="text" class="form-control" id="nomInscription" name="nomInscription" placeholder="Nom" value="<?php echo set_value('nomInscription'); ?>">
                    </div>
                    <label for="prenomInscription" class="col-md-5 control-label">Prénom <em>*</em></label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="prenomInscription" name="prenomInscription" placeholder="Prénom" value="<?php echo set_value('prenomInscription'); ?>">
                    </div>
                </div>
                 <!-- email -->
                <div class="control-group clear">
                    <label for="mailInscription" class="col-md-5 control-label">E-mail <em>*</em></label>
                    <div class="col-md-5">
                        <input type="email" class="form-control" id="mailInscription" name="mailInscription" placeholder="E-mail" value="<?php echo set_value('mailInscription'); ?>">
                    </div>
                </div>
                 <!-- mot de passe -->
                <div class="control-group clear">
                    <label for="passwordInscription1" class="col-md-5 control-label">Password <em>*</em></label>
                    <div class="col-md-5 groupe">
                        <input type="password" class="form-control" id="passwordInscription1" name="passwordInscription1" placeholder="Password">
                    </div>
                    <label for="passwordInscription2" class="col-md-5 control-label">Password vérification <em>*</em></label>
                    <div class="col-md-5">
                        <input type="password" class="form-control" id="passwordInscription2" name="passwordInscription2" placeholder="Vérification du password">
                    </div>
                </div>
                <div class="control-group clear ">
                  <div class="controls">
                    <?php echo form_submit('', 'Découvrir !', 'class="btn btn-lg btn-success btn-block"')?>
                  </div>
                </div>
              </fieldset>
            <?php echo form_close()?>
          </div>
        </div>
      </div>
    </div>
</div>
<script type="application/javascript"><!--
	$(document).ready(function() {
		
		// Erreur formulaire connexion
		$('#signin').submit(function(e){
			
			if(	$('#signin #email').val() == '' ||
				$('#signin #mdp').val() == ''
			) {
				generateError('Wingardium Leviosa...<br>Non, la connexion n\'est pas encore magique !<br> Merci de saisir un email et un mot de passe, SVP.', 'signin');
				return false;
			} else 
				return true;
		});
		
		// Erreur formulaire inscription
		$('#register').submit(function(e){
			
			if(	$('#register #nomInscription').val() == '' ||
				$('#register #prenomInscription').val() == '' ||
				$('#register #mailInscription').val() == '' ||
				$('#register #passwordInscription1').val() == '' ||
				$('#register #passwordInscription2').val() == ''
			) {
				generateError('Tous les champs doivent être indiqués avant validation !', 'register');
				return false;
			} else 
				return true;
		});
	});
--></script> 
<script type="application/javascript"><!--
	function generateError(msg, form) {
		var n = noty({
			text        : msg,
			type        : 'warning',
			dismissQueue: true,
			layout      : 'top',
			theme       : 'defaultTheme',
			killer		: true,
			maxVisible	: 1,
			timeout		: 7000,
			callback: {
				onShow: function() { if(form == 'signin') $('#email').focus(); else if(form == 'register') $('#nomInscription').focus();},
				afterShow: function() {},
				onClose: function() { if(form == 'signin') $('#mdp').focus(); else if(form == 'register') $('#nomInscription').focus();},
				afterClose: function() {}
			}	
		});
	}
--></script>