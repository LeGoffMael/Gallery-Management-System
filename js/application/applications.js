/// <reference path="../libs/jquery.d.ts" />
/// <reference path="../controleurs/controleur.ts" />
/**
 * Représente l'application Web en cours d'exécution
 */
var Application = (function () {
    function Application() {
        this.controleur = new Controleur();
        this.controleur.initialiser();
    }
    return Application;
}());
//Démarrage de l'application une fois le chargement de la page terminé
var application = null;
$(window).ready(function () { application = new Application(); });
