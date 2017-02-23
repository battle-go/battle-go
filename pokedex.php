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

      <table>

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
          <td>Il m'appartient ? <?php if ($user['id'] == $pokemon['user_id']) { echo 'oui'; } else { echo 'non'; } ?></td>
          <td><a href="pokemon.php?my_token=<?php echo $user['token']; ?>&pokemon_id=<?php echo $pokemon['id']; ?>">Detail</a></td>
        </tr>

        <?php
                          }
                          ?>


      </table>
    </article>
  </body>
</html>
