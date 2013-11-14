<div class="container">
    <!--<p class="lead">Un dicton ici, ça fait beau. Surtout sur la page : "<?=$nav?>"</p>-->
    <!--<blockquote>
      <p>Les citations donnent l'air d'être intelligent.</p>
      <small>Quelqu'un d'inconnu à <cite>Évry</cite></small> </blockquote>-->
    <br><br>
    <div id="aboutUs" class="row annonce">
      <div class="col col-sm-3 col-md-4">
        <h1>Informations diverses</h1>
      </div>
      <div class="justify col-sm-8 col-md-8">Ici se tiendront diverses informations liées aux documents et aux dernières annotations personnelles du membre. 
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
        </div>
    </div>   
    <div id="finDePage" class="row annonce">
      <div class="col col-sm-3 col-md-4">
        <h1>Informations des groupes</h1>
      </div>
      <div class="justify col-sm-8 col-md-8">
      	<i><strong>Le 12 décembre 2013</strong></i><br>
      	Evry Search - <strong>@Judith</strong> à rayé 8 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br>
        Evry Search - <strong>@Axel</strong> à surligné 2 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br><br>
        <i><strong>Le 10 décembre 2013</strong></i><br>
      	Evry Search - <strong>@Judith</strong> à rayé 8 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br>
        Evry Search - <strong>@Axel</strong> à surligné 2 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br><br>
        
      	<br>(Ici se tiendront des informations générées par les autres membres sur les groupes auxquels le membre est associé. Nous pouvons imaginés avoir des informations d'ordre statistique, qualitatives...)											
        </div>
    </div>
</div>
