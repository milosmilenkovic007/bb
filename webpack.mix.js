const mix = require('laravel-mix');
require('laravel-mix-polyfill');

mix.options({
    processCssUrls: false,
    stats: {
        children: true,
    },
});

mix
    .js('src/js/*.js', 'assets/js/main.js')
    .sass('src/sass/styles.scss', 'assets/css/') // Main styles
    .sass('src/sass/pages/home-page.scss', 'assets/css/')
    .options({
        postCss: [
            require('autoprefixer')({
                overrideBrowserslist: [
                    'Chrome >= 60',
                    'Safari >= 10.1',
                    'iOS >= 10.3',
                    'Firefox >= 54',
                    'Edge >= 15',
                    'Android >= 4',
                ],
                grid: true,
            }),
        ],
    })
    .sourceMaps(true, 'source-map')
    .minify(`assets/js/main.js`)
    .polyfill({
        enabled: true,
        useBuiltIns: 'usage',
        corejs: 2,
        targets: 'firefox 54',
    })
    .autoload({
        jquery: ['$', 'window.jQuery'],
    })
    .js('src/js/swish-payment.js', 'assets/js/swish-payment.min.js')
    .js('src/js/custom-product.js', 'assets/js/custom-product.min.js')
   // .js('src/js/swish-qr.js', 'assets/js/swish-qr.min.js')
    .sourceMaps(true, 'source-map');
