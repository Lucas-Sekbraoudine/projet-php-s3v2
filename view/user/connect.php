<form method="get" action="">

  <fieldset>

    <legend>Connexion</legend>

    <p>
      <input type='hidden' name='action' value='connected'>
    </p>

    <p>
      <input type='hidden' name='controller' value='user'>
    </p>

    <p>
      <label for="login_id">Login :</label>
      <input type="text" placeholder="exemple@gmail.com" name="login" id="login_id" required/>
    </p>

    <p>
      <label for="password_id">Mot de passe :</label>
      <input type="password" placeholder="johndeuf123" name="password" id="password_id" required/>
    </p>

    <p>

      <input type="submit" value="Envoyer" />
    </p>

  </fieldset> 

</form>