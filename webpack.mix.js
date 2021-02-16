const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .webpackConfig({
        output: {
            chunkFilename: "js/[name].js?id=[chunkhash]",
        },
        resolve: {
            alias: {
                "@": path.resolve("resources/js"),
                "@vue": path.resolve("resources/js/vue"),
                "@store": path.resolve("resources/js/store"),
                "@config": path.resolve("resources/js/config"),
                "@img": path.resolve("resources/images"),
            },
        },
    })
    .sourceMaps()
    .version()
    .browserSync({
        open: false,
        files: ["resources/js/vue/**/*.vue", "resources/js/**/*.js"],
    });
