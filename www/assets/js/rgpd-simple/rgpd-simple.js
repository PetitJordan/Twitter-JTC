(function ($) {
    /**
     * Plugin de RGPD SIMPLE
     * ex appel :
     *
     $.rgpdSimple({
        urlPageCookie: '{{ path('test') }}'
    });

     * @param options
     */
    $.rgpdSimple = function (options) {

        /**********
         * LES OPTIONS
         * @type {{eltToAppend: string, cookieName: string, urlPageCookie: string}}
         */
        var defaults = {
                cookieName:				'rgpd-simple-cookie',
                urlPageCookie:			'',
                eltToAppend:            'body'
            },
            plugin = this,
            options = options || {};


        /***********************************************
         * FONCTION QUI CREE LE HTML
         */
        plugin.addElements = function () {
            var settings = $.extend({}, defaults, options);

            var bannerHtml =
                '<div class="rgpd-banner">' +
                    '<div class="title"><h2>Le respect de votre vie privée avant tout</h2></div>' +
                        '<div class="infos">' +
                            '<div class="description">' +
                                '<p>Nous utilisons des cookies sur le site afin de vous proposer une meilleure expérience. Avec votre consentement, nous les utiliserons pour analyser l’utilisation du site et améliorer l’expérience globale.</p>' +
                                '<p>Merci de cliquer sur le bouton j’accepte pour donner votre accord. Pour en savoir pus, vous pouvez consulter à tout moment la page <a href="'+settings.urlPageCookie+'" title="Politique des cookies">politique des cookies</a>.</p>' +
                            '</div>' +
                            '<div class="links">' +
                                '<a href="" class="btn-gen red btn-refuse-rgpd" title="Je refuse">Je refuse</a>' +
                                '<a href="" class="btn-gen green btn-accept-rgpd" title="J\'accepte">J\'accepte</a>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            ;

            $(settings.eltToAppend).append(bannerHtml);
        }

        plugin.addElements();

        /***********************************************
         * FONCTION AJOUTE LES ECOUTEURS
         */

        plugin.addListeners = function () {
            var settings = $.extend({}, defaults, options);

            /**
              * Ecouteur accepter les cookies
              */
            $(document).on({
                click: function () {
                    plugin.setCookie(settings.cookieName, true, 60*60*24*30*13);
                    location.reload();
                    return false;
                }
            }, '.btn-accept-rgpd');

            /**
             * Ecouteur refuser les cookies
             */
            $(document).on({
                click: function () {
                    plugin.setCookie(settings.cookieName, false, 60*60*24*30*13);
                    location.reload();
                    return false;
                }
            }, '.btn-refuse-rgpd');
        }
        plugin.addListeners();



        /*********************************************
         * Affiche la banniere RGPD
         */
        plugin.showBanner = function () {
            $('.rgpd-banner').show();
        }

        /**********************************************
         * Recuperation cookie
         * @param cname
         * @returns {string}
         */
        plugin.getCookie = function (cname) {
            var name = cname + "=",
                ca = document.cookie.split(';'),
                i,
                c,
                ca_length = ca.length;
            for (i = 0; i < ca_length; i += 1) {
                c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) !== -1) {
                    return c.substring(name.length, c.length);
                }
            }
            return null;
        }

        /**********************************************
         * Définir cookie
         * @param variable
         * @param value
         * @param expires_seconds
         */
        plugin.setCookie = function (variable, value, expires_seconds) {
            var d = new Date();
            d = new Date(d.getTime() + 1000 * expires_seconds);
            document.cookie = variable + '=' + value + '; expires=' + d.toGMTString() + ';';
        }


        /**********************************************
         * INIT DU PLUGIN (fonction interne)
         */
        plugin.init = function () {
            var settings = $.extend({}, defaults, options);
            $.data(document, 'rgpdSimple', settings);

            var cookieRgpd = plugin.getCookie(settings.cookieName);
            if (cookieRgpd === null) {
                plugin.showBanner();
            }
        }

        // lance la fonction init interne
        plugin.init();

    }

    /***************************
     * Exemple de fonction externe, exemple appel
     *
     $.rgpdSimple.init(function () {
        console.log('hi');
    });
     *
     *
     * @param callback
     */
    // // la fonction init externe
    // $.rgpdSimple.init = function (callback) {
    //     console.log($.data(document, 'rgpdSimple'));
    //     callback();
    // }

}(jQuery));
