<?php

require_once '_include/authenticate-user.php';

// Si il n'y a pas l'ID du pokémon à ennemi.
if (!isset($_GET['dst_pokemon_id'])) {
  exit("Le parametre 'dst_pokemon_id' n'est pas present dans l'URL");
}

// Si il n'y a pas l'ID du pokémon que l'on possède.
if (!isset($_GET['src_pokemon_id'])) {
  exit("Le parametre 'src_pokemon_id' n'est pas present dans l'URL");
}


// Ajout de l'attaque dans la table MySQL.

$sql = 'INSERT INTO attacks(src_pokemon_id, dst_pokemon_id, created_at)
        VALUES(:src_pokemon_id, :dst_pokemon_id, :created_at)';

$req = $db->prepare($sql);
$req->execute(array(
	'src_pokemon_id' => $_GET['src_pokemon_id'],
	'dst_pokemon_id' => $_GET['dst_pokemon_id'],
  'created_at'     => date('Y-m-d H:i:s')
));

// Redirection vers la page du pokémon énnemi...
header('Location: pokemon.php?my_token=' . $user['token'] . '&pokemon_id=' . $_GET['dst_pokemon_id']);

?>
