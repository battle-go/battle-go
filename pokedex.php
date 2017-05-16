<?php

require_once '_include/authenticate-user.php';

?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8" />
    <title>BattleGo</title>
  </head>

  <body>
    <header>
      <h1>BattleGo</h1>

      <p>
        Bonjour, <?php echo $user['name'] ?> !
      </p>

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
        <li><a href="pokedex.php?my_token=<?php echo $user['token']; ?>">Pokedex</a></li>
        <li><a href="logout.php?my_token=<?php echo $user['token']; ?>">Se déconnecter</a></li>
      </ul>
    </nav>

    <hr />

    <article>
      <h2>Pokedex</h2>

      <table style="background-color: #ccc">

        <?php
                          // Chargement des pokemons...
                          $sql = 'SELECT *
                                  FROM `pokemons`';
                          $req = $db->prepare($sql);
                          $req->execute(array());
                          // On affiche chaque pokemon un à un.
                          while ($pokemon = $req->fetch())
                          {
                            ?>



        <tr>
          <td><?php echo $pokemon['name'] ?></td>
          <td><img src="<?php echo $pokemon['image_url'] ?>" height="100"></td>
          <td> <?php if ($user['id'] == $pokemon['user_id']) { echo '<img src="picture\possede & non possede\possede.gif" />', '<img src="picture/pokemons/151.gif" />' ; }   else { echo '<img src="picture\possede & non possede\pokeba10.png" /> <img src="picture\possede & non possede\Sprite_3_f_--.png" />'; } ?></td>

          <td><a href="pokemon.php?my_token=<?php echo $user['token']; ?>&pokemon_id=<?php echo $pokemon['id']; ?>">Detail</a></td>
        </tr>

        <?php
                          }
                          ?>


      </table>
    </article>
  </body>
</html>
