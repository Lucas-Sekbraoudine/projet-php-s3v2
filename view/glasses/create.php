<form method="get" action="">

  <fieldset>

    <legend>Création d'un article</legend>

    <p>
      <input type='hidden' name='action' value='created'>
    </p>

    <p>
      <input type='hidden' name='controller' value='glasses'>
    </p>

    <p>
      <label for="glassesid">ID article :</label>
      <input type="text" placeholder="S1" name="glassesid" id="glassesid" required/>
    </p>

    <p>
      <label for="title">Titre :</label>
      <input type="text" placeholder="Titre" name="title" id="title" required/>
    </p>

    <p>
      <label for="description">Description :</label>
      <input type="text" placeholder="Description" name="description" id="description" required/>
    </p>

    <p>
      <label for="price">Prix :</label>
      <input type="int" placeholder="Prix" name="price" id="price" required/>
    </p>

    <p>
      <label for="price">Stock :</label>
      <input type="int" placeholder="Stock" name="stock" id="stock" required/>
    </p>

    <p>
      <input type="submit" value="Envoyer" />
    </p>

  </fieldset> 

</form>