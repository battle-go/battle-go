<?php

require_once '_include/authenticate-user.php';

// Si il n'y a pas l'ID du pokémon à afficher sur la page.
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

      <h3>Activité du pokemon</h3>


      <?php
                        // Chargement des pokemons...
                        $sql = 'SELECT *
                                FROM `pokemons`, `attacks`
                                WHERE src_pokemon_id = ?
                                  AND attacks.src_pokemon_id = pokemons.id';

                        $req = $db->prepare($sql);
                        $req->execute(array($pokemon['id']));
                        // On affiche chaque pokemon un à un.
                        while ($attack = $req->fetch())
                        {
                          ?>

                            <p><?php echo $attack['created_at']; ?>, attaque vers le pokemon <?php echo $attack['dst_pokemon_id']; ?></p>

      <?php
                        }
                        ?>
      <hr>

      <!-- si le pokemon ne m'appartient pas -->
      <?php

      if ($pokemon['user_id'] != $user['id']) {
        ?>


        <h3>Lancer un duel !</h3>

        <form action="battle.php?my_token=<?php echo $user['token']; ?>&src_pokemon_id=<?php echo $pokemon['id']; ?>" method="post">
          <div>
            Choisissez le pokémon avec lequel vous voulez affronter ce pokémon...<br />
            <select name="dst_pokemon_id">


            <?php
                              // Chargement des pokemons...
                              $sql = 'SELECT *
                                      FROM `pokemons`
                                      WHERE user_id = ?';

                              $req = $db->prepare($sql);
                              $req->execute(array($user['id']));
                              // On affiche chaque pokemon un à un.
                              while ($pokemon = $req->fetch())
                              {
                                ?>



              <option value="<?php echo $pokemon['id']; ?>"><?php echo $pokemon['name']; ?></option>

            <?php
                              }
                              ?>

            </select>
          </div>

          <div>
            <input type="submit" value="Lancer le duel">
          </div>
        </form>

      <?php

      }

      ?>
    </article>
  </body>
</html>
