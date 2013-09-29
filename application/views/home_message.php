<div class="container">
  <h1>Bienvenue sur l'application</h1>
  
    <!--<p class="lead">Un dicton ici, ça fait beau. Surtout sur la page : "<?=$nav?>"</p>-->
    <blockquote>
      <p>Les citations donnent l'air d'être intelligent.</p>
      <small>Quelqu'un d'inconnu à <cite>Évry</cite></small> </blockquote>
    
    <div id="aboutUs" class="row annonce">
      <div class="col col-sm-3 col-md-4">
        <h1>About Us</h1>
      </div>
      <div class="justify col-sm-8 col-md-8">We all love reading about new things. We also like to remember what we read and use information to build our knowledge. However the workflow of finding, reading, storing, searching and sharing information on the web seems broken to us. <br>It's very random and scattered to many places.<br>Kippt grew from that frustration. We want to make your information workflow and archiving effortless. 												
        </div>
    </div>
    <?php if ($this->session->userdata('logged')) { ?>
    <p> Id : 
      <?=$this->session->userdata('id')?>
      <br>
	  Email : 
	  <?=$this->session->userdata('email')?>
      <br>
	  Logged : 
      <?=$this->session->userdata('logged')?>
    </p>
    <?php } ?>
    
    <div id="finDePage" class="row annonce">
      <div class="col col-sm-3 col-md-4">
        <h1>Fin de page</h1>
      </div>
      <div class="justify col-sm-8 col-md-8">We all love reading about new things. We also like to remember what we read and use information to build our knowledge. However the workflow of finding, reading, storing, searching and sharing information on the web seems broken to us. It's very random and scattered to many places.<br>Kippt grew from that frustration. We want to make your information workflow and archiving effortless.											
        </div>
    </div>
</div>
