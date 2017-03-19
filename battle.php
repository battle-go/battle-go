<?php

require_once '_include/authenticate-user.php';

// Si il n'y a pas l'ID du Pokémon à ennemi.
if (!isset($_GET['dst_pokemon_id'])) {
  exit("Le parametre 'dst_pokemon_id' n'est pas present dans l'URL");
}

// Si il n'y a pas l'ID du Pokémon que l'on possède.
if (!isset($_POST['src_pokemon_id'])) {
  exit("Le parametre 'src_pokemon_id' n'est pas present dans les données du formulaire");
}


// Chargement du Pokémon ennemi...
$sql = 'SELECT *
        FROM `pokemons`
        WHERE id = ?';

$r = $db->prepare($sql);

$r->execute(array($_GET['dst_pokemon_id']));

if ($r->rowCount() != 1) {
  exit('Ce pokemon ennemi est introuvable.');
}

$pokemon_ennemi = $r->fetch();


// Chargement du Pokémon allié...
$sql = 'SELECT *
        FROM `pokemons`
        WHERE id = ?';

$r = $db->prepare($sql);

$r->execute(array($_POST['src_pokemon_id']));

if ($r->rowCount() != 1) {
  exit('Ce pokemon allie est introuvable.');
}

$pokemon_allie = $r->fetch();

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
      <p style="text-align: right">
        <img src="<?php echo $pokemon_ennemi['image_url']; ?>" ?><br />
        <?php echo $pokemon_ennemi['name']; ?><br />
        <br />
        Points de vie total : <?php echo $pokemon_ennemi['live']; ?><br />

        <?php
                        // Chargement du nombre d'attaques envoyées par notre Pokémon vers le Pokémon ennemi...
                        $sql = 'SELECT COUNT(attacks.id) AS received_attacks
                                FROM `pokemons`, `attacks`
                                WHERE src_pokemon_id = ?
                                  AND dst_pokemon_id = ?
                                  AND attacks.src_pokemon_id = pokemons.id';

                        $req = $db->prepare($sql);
                        $req->execute(array($_POST['src_pokemon_id'], $_GET['dst_pokemon_id']));

                        if ($req->rowCount() != 1) {
                          exit('Le comptage des degats est impossible.');
                        }

                        $attacks = $req->fetch();
        ?>

        Dégâts recus : <?php echo $attacks['received_attacks']; ?> * <?php echo $pokemon_allie['power']; ?><br />
        Points de vie restants : <?php echo $pokemon_ennemi['live'] - ($attacks['received_attacks'] * $pokemon_allie['power']); ?><br />
        <br />
        Statut :
        <?php
          if (($attacks['received_attacks'] * $pokemon_allie['power']) > $pokemon_ennemi['live']) {
            echo "<strong style='color: red'>KO!</strong>";
          } else {
            echo "<strong style='color: green'>VIVANT</strong>";
          }
        ?>
      </p>

      <h2>VERSUS</h2>

      <p style="text-align: left">
        <img src="<?php echo $pokemon_allie['image_url']; ?>" ?><br />
        <?php echo $pokemon_allie['name']; ?><br />
        <br />
        Points de vie total : <?php echo $pokemon_allie['live']; ?><br />

        <?php
                        // Chargement du nombre d'attaques envoyées par notre Pokémon vers le Pokémon ennemi...
                        $sql = 'SELECT COUNT(attacks.id) AS received_attacks
                                FROM `pokemons`, `attacks`
                                WHERE src_pokemon_id = ?
                                  AND dst_pokemon_id = ?
                                  AND attacks.src_pokemon_id = pokemons.id';

                        $req = $db->prepare($sql);
                        $req->execute(array($_GET['dst_pokemon_id'], $_POST['src_pokemon_id']));

                        if ($req->rowCount() != 1) {
                          exit('Le comptage des degats est impossible.');
                        }

                        $attacks = $req->fetch();
        ?>

        Dégâts recus : <?php echo $attacks['received_attacks']; ?> * <?php echo $pokemon_ennemi['power']; ?><br />
        Points de vie restants : <?php echo $pokemon_allie['live'] - ($attacks['received_attacks'] * $pokemon_ennemi['power']); ?><br />
        <br />
        Statut :
        <?php
          if (($attacks['received_attacks'] * $pokemon_ennemi['power']) > $pokemon_allie['live']) {
            echo "<strong style='color: red'>KO!</strong>";
          } else {
            echo "<strong style='color: green'>VIVANT</strong>";
          }
        ?>
      </p>

      <hr />

      <form action="battle-post.php?my_token=<?php echo $user['token']; ?>&src_pokemon_id=<?php echo $pokemon_allie['id']; ?>&dst_pokemon_id=<?php echo $pokemon_ennemi['id']; ?>" method="post">
        <input type="submit" value="Lancer une attaque !">
      </form>
    </article>
  </body>
</html>
