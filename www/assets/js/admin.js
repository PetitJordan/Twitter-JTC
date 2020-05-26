require('../js/fancybox/jquery.fancybox.css');
require('../js/bxslider/css/jquery.bxslider.css');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('../css/admin/admin.scss');
// require('jquery-ui/themes/base/all.css');
require('../js/trumbowyg/ui/icons.svg');
require('../js/trumbowyg/ui/trumbowyg.min.css');

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
require('datatables.net-bs4');
require('jquery-ui');
require('jquery-ui/ui/widgets/datepicker');
require('jquery-ui/ui/widgets/sortable');
require('jquery-ui/ui/widgets/autocomplete');
require('jquery-ui/ui/effects/effect-highlight');

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

/***************************
 * DOCUMENT READY
 */

$(document).ready(function($) {


    /*********************************************
     * LEGENDS
     */
    $(document).on({
        click: function () {
            $(this).next('fieldset').slideToggle();
            $(this).toggleClass('active');
        }
    }, 'legend');

    /***************************
     * FANCYBOX
     */

    // Retire la minheight du default de fancybox
    $.extend($.fancybox.defaults, {
        minHeight: 0
    });
    $('.fancybox').fancybox();

    /***************************
     * ECOUTEUR BOUTONS DELETE FILE
     * Pour mettre une url d'ajax différente l'élément doit avoir un attribut data-url avec en valeur la route, ex dans un twig :
     * ... data-url="{{ path('monurl') }}" />
     */
    $(document).on({
        click: function () {
            if (!confirm('Supprimer ?')) {
                return false;
            }
            // l'élément sur lequel on clic
            var thisElt = $(this);
            // l'url de l'ajax
            var url = router.routing.generate('backoffice/ajax-delete-file');
            if (typeof thisElt.attr('data-url') != 'undefined') {
                url = thisElt.attr('data-url');
            }
            // l'id de l'élément à modifier en base
            var id = thisElt.attr('data-id');
            // le champ qui va être modifié
            var fileType = thisElt.attr('data-fileType');
            // le nom de l'entité qui va être modifié (en chemin complet) ex : User\User, Actuality\ActualityCategory
            var entity = thisElt.attr('data-entity');

            if (typeof id == 'undefined' || typeof fileType == 'undefined' || typeof entity == 'undefined') {
                return false;
            }

            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: 'id='+id+'&fileType='+fileType+'&entity='+entity,
                success: function(msg){
                    if (msg.error) {
                        showAlert({
                            class: 'alert-danger',
                            message: 'Une erreur est survenue'
                        });
                    } else {
                        thisElt.parents('.delete-file-wrapper').remove();
                    }
                }
            });

            return false;
        }
    }, '.btn-delete-file');


    /*************************
     *toggle unique
     */
    function toggleUnique(p) {
        // let loader = $('#preloader')
        $('#preloader').show();
        $.ajax({
            type: "POST",
            url: router.routing.generate('backoffice/ajax-toggle-unique'),
            dataType: 'json',
            data: 'id=' + p.id + '&field=' + p.field + '&value=' + p.value + '&entity=' + p.entity,
            success: function (msg) {
                if (msg.error) {
                    showAlert({
                        class: 'alert-danger',
                        message: 'Une erreur est survenue'
                    });
                } else {
                    p.thisElt.parents('tr').find('td').effect('highlight', {}, 1000);
                    // p.thisElt.bootstrapToggle('on');
                    $('.pin_toogle .toggle input[type=checkbox]').not(p.thisElt).parent().addClass('off').removeClass('btn-success').addClass('btn-secondary');
                    // return
                }
            }
        });
        $('#preloader').hide();

    }


    /***************************
     * ECOUTEUR BOUTONS TOGGLE
     * Pour mettre une url d'ajax différente l'élément doit avoir un attribut data-url avec en valeur la route, ex dans un twig :
     * ... data-url="{{ path('monurl') }}" />
     */
    $(document).on({
        change: function () {
            // l'élément sur lequel on clic
            var thisElt = $(this);
            // la value qui va être modifié
            var value = thisElt.prop('checked') ? 1 : 0;
            // l'url de l'ajax
            var url = router.routing.generate('backoffice/ajax-edit');
            if (typeof thisElt.attr('data-url') != 'undefined') {
                url = thisElt.attr('data-url');
            }
            // l'id de l'élément à modifier en base
            var id = thisElt.attr('data-id');
            // le champ qui va être modifié
            var field = thisElt.attr('data-field');
            // le nom de l'entité qui va être modifié (en chemin complet) ex : User\User, Actuality\ActualityCategory
            var entity = thisElt.attr('data-entity');

            if (typeof id == 'undefined' || typeof field == 'undefined' || typeof entity == 'undefined') {
                return;
            }

            if (thisElt.hasClass("toggle_unique")) {
                if (value) {
                    // console.log('value');
                    toggleUnique({
                        field: field,
                        id: id,
                        entity: entity,
                        value: value,
                        thisElt: thisElt
                    });
                } else {
                    // console.log('pasvalue');
                }
            } else {
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: 'id=' + id + '&field=' + field + '&value=' + value + '&entity=' + entity,
                    success: function (msg) {
                        if (msg.error) {
                            showAlert({
                                class: 'alert-danger',
                                message: 'Une erreur est survenue'
                            });
                        } else {
                            thisElt.parents('tr').find('td').effect('highlight', {}, 1000);
                        }
                    }
                });
            }

        }
    }, 'input[data-toggle="toggle"]');

    /***************************
     * REGARDE SI IL YA  DES ALERTS AU CHARGEMENT POUR SUPPRESSION AUTO
     */
    if ($('.alert-fixed').length) {
        $('.alert-fixed').each(function () {
            var thisAlert = $(this);
            setTimeout(function () {
                removeAlert({
                    element: thisAlert
                });
            }, 1000);
        })
    }

    /***************************
     * ECOUTEUR ALERTS
     */
    $(document).on({
        click: function () {
            $(this).parents('.alert-fixed').remove();
        }
    }, '.alert');

    /******************************
     * Ecouteur btn confirm
     */
    $(document).on({
        click: function () {
            var message = 'Confirmer ?';
            if ($(this).attr('title').length) {
                message = $(this).attr('title');
            }

            if (!confirm(message)) {
                return false;
            }
        }
    }, '.btn-confirm');

    /***************************
     * MENU
     */
    $('#menu-sidebar').hcOffcanvasNav({
        maxWidth: false,
        levelOpen:'expand',
        labelClose: 'Fermer',
        labelBack: 'Retour',
        levelSpacing: 10
    });

    /***************************
     * MENU KEEP OPEN
     */
    $(document).on({
        click: function () {
            sessionStorage.setItem('menuSidebarIndex', $('#menu-sidebar a').index($(this)));
        }
    }, '#menu-sidebar a');

    // check si menu deja selectionné pour ouvrir si besoin
    if (sessionStorage.getItem("menuSidebarIndex")) {
        if ($('.hc-offcanvas-nav a:eq('+sessionStorage.getItem("menuSidebarIndex")+')').parents('.nav-parent').length) {
            $('.hc-offcanvas-nav a:eq('+sessionStorage.getItem("menuSidebarIndex")+')').parents('.nav-parent').addClass('level-open');
        }
    }

    /******************************
     * Ecouteur sur les collapsable-card
     */
    $(document).on({
        click: function () {
            $(this).parents('.collapsable-card').toggleClass('open');
            return false;
        }
    }, '.collapsable-card .card-header a');


    /**
     * Cocher / Decocher tous
     */
    $(document).on({
        click: function(){

            var thisTable = $(this).parents('table:first');

            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $('input.command-line', thisTable).each(function(){
                    $(this).prop('checked',false);
                });
                $('input.table-line', thisTable).each(function(){
                    $(this).prop('checked',false);
                });
            }
            else{
                $(this).addClass('active');
                $('input.command-line', thisTable).each(function(){
                    $(this).prop('checked',true);
                });
                $('input.table-line', thisTable).each(function(){
                    $(this).prop('checked',true);
                });
            }

            if ($('.card-action').length) {
                $('.card-action').addClass('open');
            }

            return false;
        }
    },'.btn-toggle-all');

    /*****************************
     * TABLEAU TRIABLES
     */
    $('table.sortable tbody').sortable({
        placeholder: "ui-state-highlight",
        update : function () {
            // Sauvegarde l'ordre
            if (typeof savePositions != 'undefined') {
                savePositions({table: $(this).parents('table')});
            }
        },
        helper: function(e, tr){
            var originals = tr.children();
            var helper = tr.clone();
            helper.children().each(function(index){
                // Set helper cell sizes to match the original sizes
                $(this).width(originals.eq(index).width());
            });
            return helper;
        }
    });

    /**
     * ecouteur checkbox line
     */
    $(document).on({
        click: function() {
            if ($('.card-action').length) {
                $('.card-action').addClass('open');
            }
        }
    }, 'input[name="line[]"]');

    /*****************************
     * DATATABLES
     */
    $('table.dataTable').each(function() {

        var columnDefs = [];

        if (typeof ($(this).attr('data-columnDefs')) != 'undefined') {
            var arrayColumnDefs = JSON.parse($(this).attr('data-columnDefs'));
            for (var i = 0; i < arrayColumnDefs.length; i++) {
                columnDefs.push(arrayColumnDefs[i]);
            }
        }

        var table = $(this).DataTable({
            "columnDefs": columnDefs,
            "language": {
                "processing": "Traitement en cours...",
                "search": "Rechercher&nbsp;:",
                "lengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                "info": "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "infoEmpty": "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                "infoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "infoPostFix": "",
                "loadingRecords": "Chargement en cours...",
                "zeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "emptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "paginate": {
                    "first": "Premier",
                    "previous": "Pr&eacute;c&eacute;dent",
                    "next": "Suivant",
                    "last": "Dernier"
                },
                "aria": {
                    "sortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                }
            },
            "pageLength": 50
        });

        if ($(this).hasClass('filters-footer')) {

            $("tfoot th", this).each(function (i) {
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(this).empty())
                    .on('change', function () {
                        table.column(i)
                            .search($(this).val())
                            .draw();
                    });

                table.column(i).data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });


    /*****************************
     * wysiwyg
     */
    var simpleWysiwygs = [];
    $('textarea.simple-wysiwyg').each(function () {
        var thisElt = $(this);
        var currentWysiwyg = thisElt.trumbowyg({
            lang: 'fr',
            svgPath: thisElt.attr('data-svgPath'),
            btnsDef: {
                // Customizables dropdowns
                image: {
                    dropdown: ['insertImage', 'upload'],
                    ico: 'insertImage'
                }
            },
            btns: [
                ['viewHTML'],
                ['undo', 'redo'],
                ['formatting'],
                ['fontsize'],
                ['strong', 'em', 'del', 'underline'],
                ['link'],
                ['image'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['foreColor', 'backColor'],
                ['preformatted'],
                ['horizontalRule'],
                ['fullscreen'],
                ['historyUndo','historyRedo']
            ],
            plugins: {
                upload: {
                    // Some upload plugin options, see details below
                    serverPath: thisElt.attr('data-ajax-upload-url'),
                    // nom du post de l'image
                    fileFieldName: 'fileToUpload',
                    // nom de l'url de l'image dans le retour json
                    urlPropertyName: 'pictureUrl',
                    // autres paramètres à passer
                    data: [
                        {name: 'entity', value: thisElt.attr('data-entity')},
                        {name: 'id', value: thisElt.attr('data-id')}
                        ]
                },
                resizimg: {
                    minSize: 64,
                    step: 16,
                }
            }
        });

        simpleWysiwygs.push(currentWysiwyg);
    });
});

/***************************
 * Dans quelle vue de bootstrap on est
 */

var viewport_xs_max = 576;
var viewport_sm_max = 768;
var viewport_md_max = 992;
var viewport_lg_max = 1200;

global.getBootstrapViewport = function()
{
    if ($(window).width() < viewport_xs_max) {
        return 'xs';
    }
    else if ($(window).width() >= viewport_xs_max &&  $(window).width() < viewport_sm_max) {
        return 'sm';
    }
    else if ($(window).width() >= viewport_sm_max &&  $(window).width() < viewport_md_max) {
        return 'md';
    }
    else if ($(window).width() >= viewport_md_max &&  $(window).width() < viewport_lg_max) {
        return 'lg';
    }
    else  {
        return 'xl';
    }
}

/***************************
 * AFFICHER ALERTE
 */
global.showAlert = function(params)
{
    var alert =  $('<div class="alert-fixed"><div class="alert '+params.class+'"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+params.message+'</div></div>').prependTo('body');
    setTimeout(function(){
        removeAlert({
            element: alert
        });
    }, 3000);
}

/***************************
 * CACHER ALERTE
 */
global.removeAlert = function(params)
{
    if (typeof $(params.element) != 'undefined' && $(params.element).length) {
        $(params.element).fadeOut('slow', function() {
            $(params.element).remove();
        })
    }
}

/*****************************
 * TABLEAU TRIABLES
 * Pour personalisé l'url ajax de tri la table doit avoir un attribut data-url_sortable, ex:
 * <table data-url_sortable="{{ path('monurl') }}">
 */

function savePositions(p){
    // recupère la liste des ids
    var strIds = '';
    $('tr', p.table.find('tbody')).each(function(index) {
        strIds += parseInt($(this).attr('data-id'))+',';
    });

    // url de tri par défaut
    var urlSortable = router.routing.generate('backoffice/ajax-sort');

    // si on a une url spécifique
    if (typeof p.table.attr('data-url_sortable') != 'undefined') {
        urlSortable = p.table.attr('data-url_sortable');
    }

    // vérifie qu'on a bien l'entité
    if (typeof p.table.attr('data-entity') == 'undefined') {
        showAlert({
            class: 'alert-danger',
            message: 'Impossible de trouver l\'entité associée'
        });
        return false;
    }

    // la requete ajax
    $.ajax({
        url: urlSortable,
        type: "POST",
        data: "strIds="+strIds+'&entity='+p.table.attr('data-entity'),
        dataType: 'json',
        success: function(result) {
            if (result.error == 1) {
                showAlert({
                    class: 'alert-danger',
                    message: result.message
                });

            } else {
                if (result.message) {
                    location.reload();
                    showAlert({
                        class: 'alert-success',
                        message: result.message
                    });
                }
            }
        }
    });




}



