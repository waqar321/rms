const mix = require('laravel-mix');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .setPublicPath('public')
   .sourceMaps();

mix.webpackConfig({
    plugins: [
        new BrowserSyncPlugin({
            host: 'localhost',
            port: 3000,
            proxy: 'your-local-domain.test', // Change to your local domain
            files: [
                'public/js/*.js',
                'public/css/*.css',
                'resources/views/**/*.php'
            ],
            notify: false,
        })
    ]
});
