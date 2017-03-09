<?php

require_once '_include/authenticate-user.php';

?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8" />
    <title>BattleGo</title>

    <link rel="stylesheet" media="screen" href="style.css">

        <!-- CSS  -->
           <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

           <!-- Compiled and minified CSS -->
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">

           <!--  Scripts-->
           <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

           <!-- Compiled and minified JavaScript -->
           <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>



  </head>

  <body>
    <header>
      <h1>BattleGo</h1>
    </header>

    <hr />

    <nav>
      <ul>
        <li><a href="pokedex.php?my_token=<?php echo $user['token']; ?>">Pokedex</a></li>
        <li><a href="logout.php?my_token=<?php echo $user['token']; ?>">Se déconnecter</a></li>
      </ul>
    </nav>

    <hr />

    <article>
      <h2>Duel</h2>

      <div>
        <!-- pokemon du dresseur adverse -->
        <!-- pour y arriver, il faut utiliser la variable PHP : $_POST['dst_pokemon_id'] -->

        <?php echo $_POST['dst_pokemon_id']; ?>
      </div>

      <div>
        <!-- pokemon du dresseur connecté -->
        <!-- pour y arriver, il faut utiliser la variable PHP : $_GET['src_pokemon_id'] -->

        <?php echo $_GET['src_pokemon_id']; ?>
      </div>

      <form action="battle-post.php" method="post">
        <!-- Ici, il faut mettre un bouton pour soumettre une attaque vers le pokemon adverse. -->

        <input type="submit">

        <!-- Apres chaque attaque, la page battle-post.php doit enregistrer l'attaque dans la table 'attacks',
        et ensuite rediriger sur la page battle.php pour que l'on puisse continuer le combat. -->

        <!-- Le combat s'arrete quand un des 2 pokemons a 0 ou un nombre negatif de points de vie. -->

        <!-- Remarque : Pour compter le nombre de point de vie d'un pokemon, il faut faire une requete SQL avec la fonction sum() -->
      </form>
    </article>
  </body>
</html>
