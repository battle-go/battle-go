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

      ici, on peut mettre la liste des duels de ce pokemon.

      <h3>Lancer un duel !</h3>

      <form action="battle.php?my_token=<?php echo $user['token']; ?>&src_pokemon_id=<?php echo $pokemon['id']; ?>" method="post">
        <div>
          Choisissez le pokémon avec lequel vous voulez affronter ce pokémon...<br />
          <select name="select">
            <option value="valeur1">Boo</option>
            <option value="valeur2">Mokumokuren</option>
          </select>
        </div>

        <div>
          <input type="submit" value="Lancer le duel">
        </div>
      </form>
    </article>
  </body>
</html>
