<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 14/03/2019
 * Time: 14:51
 */

namespace App\Utils\Various;

class Constant
{

    /*******************************************************
     * FILE TYPE
     */

    const FILE_TYPE_ATTACHMENT = 'attachment';
    const FILE_TYPE_MEDIA = 'media';

    /*******************************************************
     * STATUS
     */
    const STATUS_VALIDATE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_WAITING_VALIDATION = 3;
    const STATUS_REFUSED = 4;
    const STATUS_DESACTIVATED = 5;


    /*******************************************************
     * PUBLICATION
     */
    const PUBLISH_CURRENT = 'current';
    const PUBLISH_INCOMMING = 'incomming';
    const PUBLISH_EXPIRED = 'expired';

    /*******************************************************
     * USER
     */
    const ROLE_USER = 'ROLE_USER';
    const ROLE_API = 'ROLE_API';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    const GENDER_MR = 1;
    const GENDER_MRS = 2;

    const PASSWORD_MIN_LENGTH = 6;

    const GROUP_CLIENTS = 'clients';
    const GROUP_ADMIN = 'admins';

    /*******************************************************
     * GOOGLE
     */
    const GOOGLE_MAPS_KEY = 'kleybidon';
    const GOOGLE_MAPS_KEY_PHP = 'kleybidon';



    /*******************************************************
     * FOLDER
     */
    const UPLOAD_FOLDER = 'upload';
    const PUBLIC_FOLDER = 'public';

    /*******************************************************
     * API
     */

    const API_ERROR_RECIPIENT_NOT_FOUND = 100;
    const API_ERROR_RECIPIENT_NOT_FOUND_TEXT = 'Récipient introuvable';

    const API_ERROR_NO_PHOTO = 200;
    const API_ERROR_NO_PHOTO_TEXT = 'Plus de photos sur ce récipient';

    const API_ERROR_DATE_VALIDITY = 300;
    const API_ERROR_DATE_VALIDITY_TEXT = 'Date de validité du récipient expiré';

    const API_ERROR_USER_FORBIDDEN = 400;
    const API_ERROR_USER_FORBIDDEN_TEXT = 'Utilisateur non autorisé';

    /*******************************************************
     * PRODUITS
     */

    const PRODUCT_CATEGORY_SUBSCRIPTION = 'abonnement-photo';
    const PRODUCT_CATEGORY_COMPLEMENT = 'produits-complementaires';


    /*******************************************************
     * COUNTRY PRICE
     */

    const ID_CURRENT_COUNTRY_PRICE_SESSION = 'id_current_country_price';

    /*******************************************************
     * PACK
     */
    const ID_CURRENT_PACK_SESSION = 'id_current_pack';

    /*******************************************************
     * CART
     */
    const ID_CURRENT_CART_SESSION = 'id_current_cart';

    /*******************************************************
     * RECIPIENT
     */
    const ID_CURRENT_RECIPIENT_SESSION = 'id_current_recipient';
    const EMAIL_DOMAIN = '@symfony4.com';
}
