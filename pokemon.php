<?php

require_once '_include/authenticate-user.php';

// Si il n'y a pas l'ID du Pokémon à afficher sur la page.
if (!isset($_GET['pokemon_id'])) {
  exit("Le parametre 'pokemon_id' n'est pas present dans l'URL");
}

// Chargement du code de la fonction...
$sql = 'SELECT *
        FROM `pokemons`
        WHERE id = ?';

$r = $db->prepare($sql);

$r->execute(array($_GET['pokemon_id']));

if ($r->rowCount() != 1) {
  exit('Ce pokemon est introuvable.');
}

$pokemon = $r->fetch();

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
      <h2><?php echo $pokemon['name']; ?></h2>

      <p>
        Vie : <?php echo $pokemon['live']; ?><br />
        Puissance : <?php echo $pokemon['power']; ?><br />
        Vitesse : <?php echo $pokemon['speed']; ?>
      </p>

      <p>
        <img src="<?php echo $pokemon['image_url']; ?>">
      </p>

      <?php
        if ($pokemon['user_id'] == $user['id']) {
          echo "<p>Ce Pokémon vous appartient.</p>";
        }
      ?>

      <h3>Liste des attaques reçues par ce pokemon</h3>

      <ol>
        <?php
                        // Chargement des attaques reçues...
                        $sql = 'SELECT *
                                FROM `pokemons`, `attacks`
                                WHERE dst_pokemon_id = ?
                                  AND attacks.src_pokemon_id = pokemons.id';

                        $req = $db->prepare($sql);
                        $req->execute(array($pokemon['id']));
                        // On affiche chaque pokemon un à un.
                        while ($attack = $req->fetch())
                        {
                          ?>

                            <li>
                              Le <?php echo $attack['created_at']; ?>,
                              réception d'une attaque vers le
                              <a href="pokemon.php?my_token=<?php echo $user['token']; ?>&pokemon_id=<?php echo $attack['src_pokemon_id']; ?>">
                                <strong>pokemon <?php echo $attack['name']; ?></strong>
                                <img src="<?php echo $attack['image_url']; ?>" height="50">
                              </a>
                            </li>

                          <?php
                        }
        ?>
      </ol>

      <h3>Liste des attaques envoyées par ce pokemon</h3>

      <ol>
        <?php
                        // Chargement des attaques envoyées...
                        $sql = 'SELECT *
                                FROM `pokemons`, `attacks`
                                WHERE src_pokemon_id = ?
                                  AND attacks.dst_pokemon_id = pokemons.id';

                        $req = $db->prepare($sql);
                        $req->execute(array($pokemon['id']));
                        // On affiche chaque pokemon un à un.
                        while ($attack = $req->fetch())
                        {
                          ?>

                            <li>
                              Le <?php echo $attack['created_at']; ?>,
                              envoie d'une attaque vers le
                              <a href="pokemon.php?my_token=<?php echo $user['token']; ?>&pokemon_id=<?php echo $attack['dst_pokemon_id']; ?>">
                                <strong>pokemon <?php echo $attack['name']; ?></strong>
                                <img src="<?php echo $attack['image_url']; ?>" height="50">
                              </a>
                            </li>

                          <?php
                        }
        ?>
      </ol>

      <!-- si le pokemon ne m'appartient pas -->
      <?php

      if ($pokemon['user_id'] != $user['id']) {
        ?>

        <hr>

        <div id="battle">

        <h3>Lancer un duel !</h3>

        <p>
          Choisissez le Pokémon avec lequel vous voulez affronter ce Pokémon...
        </p>

        <form action="battle.php?my_token=<?php echo $user['token']; ?>&dst_pokemon_id=<?php echo $pokemon['id']; ?>" method="post">
          <select name="src_pokemon_id">
            <?php
              // Chargement des pokemons...
              $sql = 'SELECT *
                      FROM `pokemons`
                      WHERE user_id = ?';

              $req = $db->prepare($sql);
              $req->execute(array($user['id']));
              // On affiche chaque pokemon que l'on possède (allié), un à un.
              while ($pokemon = $req->fetch())
              {
                ?>

                <option value="<?php echo $pokemon['id']; ?>"><?php echo $pokemon['name']; ?></option>

                <?php
              }
            ?>
          </select>

          <input type="submit" value="Lancer le duel">
        </form>

      </div>

      <?php

      }

      ?>
    </article>

    <script>
      $(document).ready(function() {
        $('select').material_select();
      });
    </script>
  </body>
</html>
