var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    .addEntry('plugins', [
        './assets/js/unveil/jquery.unveil.js',
        './assets/js/hc-offcanvas/hc-offcanvas-nav.js',
        './assets/js/bxslider/js/jquery.bxslider.js',
        './assets/js/fancybox/jquery.fancybox.pack.js',
        './assets/js/rgpd-simple/rgpd-simple.js'
    ])

    .addEntry('wysiwyg', [
        './assets/js/trumbowyg/trumbowyg.min.js',
        './assets/js/trumbowyg/langs/fr.min.js',
        './assets/js/trumbowyg/plugins/cleanpaste/trumbowyg.cleanpaste.js',
        './assets/js/trumbowyg/plugins/upload/trumbowyg.upload.js',
        './assets/js/trumbowyg/jquery-resizable.min.js',
        './assets/js/trumbowyg/plugins/resizimg/trumbowyg.resizimg.js',
        './assets/js/trumbowyg/plugins/history/trumbowyg.history.js',
        './assets/js/trumbowyg/plugins/fontsize/trumbowyg.fontsize.min.js'
    ])

    .addEntry('admin', [
        './assets/js/admin.js',
    ])

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning()

    // enables @babel/preset-env polyfills
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')

    // permet de garder la structure du dossier images
    .configureFilenames({
        images: '[path][name].[hash:8].[ext]',
    })

    // gestion des PDF dans assets
    .addLoader({
        test: /\.(pdf)$/,
        loader: 'file-loader',
        options: {
            name: '[name].[ext]',
            outputPath: './assets/pdfs/'
        }
    })

    // copy folder
    // .copyFiles({
    //     from: './assets/datas',
    //
    //     // if versioning is enabled, add the file hash too
    //     to: 'assets/datas/[path][name].[hash:8].[ext]',
    //
    //     // only copy files matching this pattern
    //     //pattern: /\.(png|jpg|jpeg)$/
    // })
;

module.exports = Encore.getWebpackConfig();
