<!-- vue de la page de connexon -->
<div class="container">
  
  <?=form_open('index.php/membre/signin', 'class="form-signin" role="form"')?>
  <h2 class="form-signin-heading">Willkommen !</h2>
  <?=form_error('login', '<span class="label label-warning">','</span><br/>'); ?>
  <?=form_error('mdp', '<span class="label label-warning">','</span><br/>'); ?>
  <?php if(isset($error)):echo $error;endif;?>
  <input id="email" name="login" type="email" autofocus="" placeholder="Login" class="form-control" value="<?php echo set_value('login'); ?>">
  <input id="mdp" name="mdp" type="password" placeholder="Password" class="form-control">
  <!-- <label class="checkbox">
          <input type="checkbox" value="rester-connecter"> Se souvenir de moi
        </label>-->
  <?=form_submit('', 'Valider', 'class="btn btn-lg btn-primary btn-block"')?>
  <?=anchor('index.php/membre/register', 'S\'inscrire', 'class="btn btn-large btn-default btn-block"')?>
  </form>
</div>


<br><Br><br><br>


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
