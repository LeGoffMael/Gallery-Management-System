<?php
/**
 * La configuration de votre installation
 *
 * Ce fichier contient les réglages de configuration de la base données MySQL
 *
 * /!\ Vous pouvez modifier directement ce fichier mais faites attention à ce qu'il corresponde à la réalité
 *
 * @author Maël Le Goff <legoffmael@gmail.com>
 */

// ** Réglages MySQL (nécessaire aux commande PDO)- Votre hébergeur doit vous fournir ces informations ** //
/** Nom de la base de données */
define( 'DB_NAME', 'galleries' );

/** Utilisateur de la base de données */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de donées */
define( 'DB_PASSWORD', '' );

/** Adresse de l'hébergement MySQL */
define( 'DB_HOST', 'localhost' );

/** Jeux de caractère de la base de données */
define( 'DB_CHARSET', 'utf8' );
?>