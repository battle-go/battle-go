<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8" />
    <title>BattleGo</title>
  </head>

  <body>
    <header>
      <h1>BattleGo</h1>

      <link rel="stylesheet" media="screen" href="style.css">

          <!-- CSS  -->
             <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

             <!-- Compiled and minified CSS -->
             <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">

             <!--  Scripts-->
             <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

             <!-- Compiled and minified JavaScript -->
             <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>



    </header>

    <hr />

    <nav>
      <ul>
        <li>S'inscrire</li>
        <li><a href="login.php">Connexion</a></li>
      </ul>
    </nav>

    <hr />

    <article>
      <h2>S'inscrire à BattleGo</h2>

      <form action="signup-post.php" method="post">
        <div>
          <input name="name" type="text" placeholder="Pseudo" required>
        </div>

        <div>
          <input name="email" type="email" placeholder="Courriel" required>
        </div>

        <div>
          <input name="password" type="password" placeholder="Mot de passe" required>
        </div>

        <div>
          <input class="btn" type="submit" value="Créer mon compte">
        </div>
      </form>
    </article>
  </body>
</html>
