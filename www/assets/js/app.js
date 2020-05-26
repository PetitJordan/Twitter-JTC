require('../js/fancybox/jquery.fancybox.css');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('../js/rgpd-simple/rgpd-simple.css');
require('../css/app.scss');
require('../../node_modules/infinite-scroll/dist/infinite-scroll.pkgd.min');

// Images
const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp|pdf)$/);
imagesContext.keys().forEach(imagesContext);

// PDFS
const pdfsContext = require.context('../pdfs', true, /\.(pdf)$/);
pdfsContext.keys().forEach(pdfsContext);

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');
require('jquery-ui');
require('jquery-ui/ui/widgets/datepicker');
require('jquery-ui/ui/i18n/datepicker-fr');
// require('datatables.net-bs4');

/***************************
 * ROUTING JS
 * ex :
 * router.routing.generate('monurl')
 * router.routing.generate('monurl2', {'param1': 'value1', 'params2': 'value2})
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * Les routes routes doivent avoir l'option expose true, ex :
 *
 backoffice/ajax-sort:
 path: backoffice/ajax-sort
 controller: App\Controller\Backoffice\BackofficeController:ajaxSort
 options:
 expose: true

 Après la création d'une nouvelle route vous devez également lancer la commande suivante pour récupérer les routes dans le JS

 php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json

 puis compiler les assets

 yarn encore dev
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */

// import le fichier router dans ce fichier
const router = require('./router.js');
// permet son utilisation dans les fichiers twig
global.router = router;


$(document).ready(function ($) {


        /***************************
         * LANGUAGE SWITCHER
         */

        $(document).on({
            change: function () {
                var thisElt = $(this);
                $.ajax({
                    type: "POST",
                    url: router.routing.generate('ajax/set-locale'),
                    dataType: 'json',
                    data: {
                        language: thisElt.val()
                    },
                    success: function (msg) {
                        if (!msg.success) {
                            showAlert({
                                class: 'alert-danger',
                                message: 'Une erreur est survenue'
                            });
                        } else {
                            if (thisElt.find('option:selected').attr('data-url')) {
                                location.href = thisElt.find('option:selected').attr('data-url');
                            } else {
                                document.location.reload();
                            }
                        }
                    }
                });
            }
        }, 'select[name="language-switcher"]');

        /***************************
         * UNVEIL
         */
        $('.unveil').unveil();

        /***************************
         * ECOUTEUR ALERTS
         */
        $(document).on({
            click: function () {
                $(this).remove();
            }
        }, '.alert');


        /***************************
         * ECOUTEUR PASSWORD SEEABLE
         */
        $(document).on({
            click: function () {
                $(this).parent().find('input[type="password"]').prop('type', 'text');
                return false;
            }
        }, '.password-seeable i');

        /***************************
         * ECOUTEUR DATEPICKER
         */
        $('.birthdaypicker-widget').datepicker({
                buttonText: "Choose",
                dateFormat: 'd/m/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "-120y:-18y",
                defaultDate: "-30y",
                onSelect: function (dateText, inst) {
                    var dates = dateText.split('/');
                    var parent = inst.dpDiv.parents('.datepicker');

                    var day = dates[0];
                    var month = dates[1];
                    var year = dates[2];

                    $("select[name*='day']", parent).val(day);
                    $("select[name*='month']", parent).val(month);
                    $("select[name*='year']", parent).val(year);

                    $(this).toggleClass('visible');
                },
            },
            $.datepicker.regional["fr"]
        );


        $(document).on({
            click: function () {
                $(this).parents('.datepicker').find('.datepicker-widget').toggleClass('visible')
                $(this).parents('.datepicker').find('.birthdaypicker-widget').toggleClass('visible')
            }
        }, '.datepicker-widget-wrapper i');


        /***************************
         * ECOUTEUR FANCYBOX
         */
        if ($().fancybox) {
            // Fermeture fancybox
            $(document).on({
                click: function () {
                    $.fancybox.close();
                    return false;
                }
            }, '.btn-close-fancybox-custom');


            /***************************
             * Dans quelle vue de bootstrap on est
             */
            var viewport_xs_max = 576;
            var viewport_sm_max = 768;
            var viewport_md_max = 992;
            var viewport_lg_max = 1200;

            global.getBootstrapViewport = function () {
                if ($(window).width() < viewport_xs_max) {
                    return 'xs';
                } else if ($(window).width() >= viewport_xs_max && $(window).width() < viewport_sm_max) {
                    return 'sm';
                } else if ($(window).width() >= viewport_sm_max && $(window).width() < viewport_md_max) {
                    return 'md';
                } else if ($(window).width() >= viewport_md_max && $(window).width() < viewport_lg_max) {
                    return 'lg';
                } else {
                    return 'xl';
                }
            }

            /***************************
             * CACHER ALERTE
             */


// fadeout message_flash
            window.setTimeout(fadeMyDiv(), 3000);

            function fadeMyDiv() {
                $(".alert-fixed").fadeOut(3000);
            }


            global.removeAlert = function (params) {
                if (typeof $(params.element) != 'undefined' && $(params.element).length) {
                    $(params.element).fadeOut('slow', function () {
                        $(params.element).remove();
                    })
                }
            }

            /**
             * Pour ne pas trigger plusieurs fois un event
             */
            global.waitForFinalEvent = (function () {
                var timers = {};
                return function (callback, ms, uniqueId) {
                    if (!uniqueId) {
                        uniqueId = "Don't call this twice without a uniqueId";
                    }
                    if (timers[uniqueId]) {
                        clearTimeout(timers[uniqueId]);
                    }
                    timers[uniqueId] = setTimeout(callback, ms);
                };
            })();

        }
    }
);