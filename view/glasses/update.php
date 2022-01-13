<form method="get" action="">

  <fieldset>

    <legend>MAJ des informations de l'article</legend>

    <p>
      <input type='hidden' name='action' value='updated'>
    </p>
    <p>
      <input type='hidden' name='controller' value='glasses'>
    </p>
    
    <p>
    <label for="newglassesid_id">ID:</label> 
    <input readonly type="text" placeholder="nouvel ID" name="newglassesid" id="newglassesid_id" value="<?= $id ?>">
    </p> 

    <p>
      <label for="newtitle_id">Titre :</label> 
      <input type="text" placeholder="nouveau titre" name="newtitle" id="newtitle_id" />
    </p>
    
    <p>
      <label for="newdescription_id">Description :</label> 
      <input type="text" placeholder="nouvelle description" name="newdescription" id="newdescription_id" />
    </p>

    <p>
    <label for="newprice_id">Prix :</label> 
    <input type="int" placeholder="nouveau prix" name="newprice" id="newprice_id" />
    </p>

    <p>
    <label for="newstock_id">Stock :</label>  
    <input type="int" placeholder="nouveau stock" name="newstock" id="newstock_id" />
    </p>

    <p>
      <input type="hidden" name="title" id="title_id" value="<?=rawurlencode($g->getTitle())?>"/>
    </p>

    <p>
      <input type="hidden" name="description" id="description_id" value="<?=rawurlencode($g->getDescription())?>"/>
    </p>
    
    <p>
      <input type="hidden" name="price" id="price_id" value=<?=rawurlencode($g->getPrice())?>/>
    </p>

    <p>
      <input type="hidden" name="stock" id="stock_id" value=<?=rawurlencode($g->getStock())?>/>
    </p>

    <p>
      <input type="submit" value="Envoyer" />
    </p>

  </fieldset> 

</form>