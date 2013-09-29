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
            <?php echo form_open('membre/signin', 'class="form-signin" role="form"')?>
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
            <?php echo form_open('membre/register', 'class="form-horizontal form-register" role="form"')?>
              <fieldset>
                <div id="legend">
                  <legend class="text-muted">Inscription aux services Pouet</legend>
                </div>
                <div class="control-group clear">
                    <label for="loginInscription" class="col-md-5 control-label">Login</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="loginInscription" name="loginInscription" placeholder="Login">
                    </div>
                </div>
                <div class="control-group clear">
                    <label for="mailInscription" class="col-md-5 control-label">E-mail</label>
                    <div class="col-md-5">
                        <input type="email" class="form-control" id="mailInscription" name="mailInscription" placeholder="E-mail">
                    </div>
                </div>
                <div class="control-group clear">
                    <label for="passwordInscription1" class="col-md-5 control-label">Password</label>
                    <div class="col-md-5 groupe">
                        <input type="password" class="form-control" id="passwordInscription1" name="passwordInscription1" placeholder="Password">
                    </div>
                    <label for="passwordInscription2" class="col-md-5 control-label">Password vérification</label>
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
<!-- le tableau devient responsive
<div class="table-responsive">
  <table class="table table-hover" id="membre">
    <tr>
      <th>#</th>
      <th>login</th>
      <th>password</th>
    </tr>
    <tr>
      <td> #99 </td>
      <td> Doe </td>
      <td> ***** </td>
    </tr>
    <tr class="warning">
      <td> #99 (tr class="warning") </td>
      <td> Doe </td>
      <td> ***** </td>
    </tr>
    <tr>
      <td> #99 </td>
      <td class="success"> Doe (class=active) </td>
      <td> ***** </td>
    </tr>
    <tr>
      <td> #99 </td>
      <td> Doe </td>
      <td> ***** </td>
    </tr>
  </table>
</div>--> 
