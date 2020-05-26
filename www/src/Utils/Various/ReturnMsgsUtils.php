<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 27/12/2017
 * Time: 10:13
 */

namespace App\Utils\Various;


class ReturnMsgsUtils
{
    /*******************************************************
     * Message de retour
     */

    const GENERIC_ERROR = 'Une erreur est survenue';

    const LOADING_ERROR = 'Impossible de charger l\'élément demandé.';

    const UPDATE_ERROR = 'Erreur lors de la mise à jour';
    const UPDATE_SUCCESS = 'Mise à jour effectuée';

    const SAVE_SUCCESS = 'Données enregistrées';
    const SAVE_ERROR = 'Impossible d\'enregistrer';

    const DELETE_SUCCESS = 'Données supprimées';
    const DELETE_ERROR = 'Impossible de supprimer';

    const LOGIN_ERROR = 'Impossible de vous connecter';

    const REGISTER_DUPLICATE = 'Cet email est déjà inscrit';
    const REGISTER_ERROR = 'Impossible de vous enregistrer';

    const SORT_SUCCESS = 'Ordre sauvegardé';
    const SORT_ERROR = 'Impossible de sauvegarder l\'ordre';

    const CONTACT_ERROR = 'Impossible d\'envoyer votre message';
    const CONTACT_SUCCESS = 'Votre message à bien été pris en compte';

    const AUTHORIZATION_ERROR = 'Vous n\'avez pas le niveau nécessaire pour cette action';

    const REGISTER_NEWSLETTER_OK = 'Votre email à bien été enregistré';

    const DUPLICATE_SUCCESS = 'Object dupliqué';

    const RECIPIENT_EMAIL_EXISTING = 'Cet email est déjà utilisé';
    const RECIPIENT_FORBIDDEN = 'Vous n\'avez pas l\'autorisation d\'utiliser cet email';

    const NO_COMPLEMENT_CHOOSED = 'Veuillez choisir au moins un produit complémentaire';


    const DISCOUNT_CODE_USER_ALREADY_PRESENT = 'Cet utilisateur est déjà associé au code de réduction';
    const DISCOUNT_CODE_FORBIDDEN = 'Vous ne pouvez pas utiliser ce code de réduction';

    /*******************************************************
     * Fichiers
     */
    const FILE_BAD_FORMAT = 'Fichier au mauvais format';
    const FILE_UPLOAD_ERROR = 'Erreur lors de l\'envoi de votre fichier';

    /*******************************************************
     * PDF
     */
    const PDF_GENERATE_ERROR = 'Impossible de générer votre PDF';

    /*******************************************************
     * UTILISATEURS
     */

    const EMAIL_NOT_FOUND = 'Impossible de trouver l\'email dans notre base de données';
    const NEW_PASSWORD_SENT = 'Un nouveau mot de passe vous à été envoyé sur votre email';

    const PASSWORD_ERROR = 'Le mot de passe est incorrect';
    const PASSWORD_UPDATE_SUCCESS = 'Le mot de passe à été mis à jour';
    const PASSWORD_MISSMATCH = 'La confirmation de mot de passe est incorrecte';
    const PASSWORD_TOO_SHORT = 'Le mot de passe est trop court, '.Constant::PASSWORD_MIN_LENGTH. ' caractères minimum';

    /*******************************************************
     * Classes des messages de retours
     */
    const CLASS_SUCCESS = 'alert alert-success';
    const CLASS_ERROR = 'alert alert-danger';
    const CLASS_WARNING = 'alert alert-warning';
    const CLASS_INFO = 'alert alert-info';
    const CLASS_DISMISSIBLE = 'alert-dismissible';
    const CLASS_FIXED = 'alert-fixed';
}
