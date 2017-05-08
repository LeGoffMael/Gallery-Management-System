/// <reference path="../libs/jquery.d.ts" />
/// <reference path="../controleurs/controleur.ts" />

/**
 * Représente l'application Web en cours d'exécution
 */
class Application
{
  //Controleur principal de l'application
  private controleur: Controleur;

    constructor()
    {
        this.controleur = new Controleur();
        this.controleur.initialiser();
    }
}

//Démarrage de l'application une fois le chargement de la page terminé
var application: Application = null;
$(window).ready(() => { application = new Application(); });