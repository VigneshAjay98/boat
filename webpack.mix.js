const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


// mix.js(
//       [
//          // 'resources/js/app.js',
//          "node_modules/summernote/dist/summernote.min.js",
//          "node_modules/summernote/dist/summernote-bs5.min.js",
//       ],

//       'public/js')
mix.js('resources/js/all.js', 'public/js')
   .js('resources/js/app-scripts/front-common.js', 'public/front/js')
   .js('resources/js/app-scripts/payment.js', 'public/front/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/custom.scss', 'public/css')
    .css('resources/css/front.css', 'public/css')
    .css('resources/css/mail-invoice.css', 'public/css')
    .sourceMaps();
mix.scripts(
    [
        'resources/front/front_assets/jquery-3.6.0/jquery-3.6.0.min.js',
        'resources/front/front_assets/bootstrap/dist/js/bootstrap.bundle.min.js',
        'resources/front/front_assets/jquery-validation/jquery.validate.min.js',

        'resources/front/front_assets/simplebar/dist/simplebar.min.js',
        'resources/front/front_assets/smooth-scroll/dist/smooth-scroll.polyfills.min.js',
        'resources/front/front_assets/tiny-slider/dist/min/tiny-slider.js',
        'resources/front/front_assets/nouislider/dist/nouislider.min.js',
        'resources/front/front_assets/lightgallery.js/dist/js/lightgallery.min.js',
        'resources/front/front_assets/lg-video.js/dist/lg-video.min.js',
        'resources/front/front_assets/jarallax/dist/jarallax.min.js',
        'resources/front/front_assets/jarallax/dist/jarallax-element.min.js',
        'resources/front/front_assets/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js',
        'resources/front/front_assets/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js',
        'resources/front/front_assets/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js',
        'resources/front/front_assets/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js',
        'resources/front/front_assets/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js',
        'resources/front/front_assets/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js',
        'resources/front/front_assets/filepond/dist/filepond.min.js',
        'resources/front/front_assets/cleave.js/dist/cleave.min.js',
        'resources/front/front_assets/flatpickr/dist/flatpickr.min.js',
        'resources/front/front_assets/summernote/dist/summernote.min.js',
        'resources/front/front_assets/toastr/dist/toastr.min.js',
        'resources/front/front_assets/select2-4.1.0/dist/js/select2.min.js',
        'resources/front/front_assets/DataTables/DataTables-1.11.3/js/jquery.dataTables.min.js',
        'resources/front/front_assets/fontawesome-free-6.0.0-beta3-web/js/all.min.js'
    ],
    "public/js/front-libraries.js"
    );
mix.copyDirectory("resources/img", "public/storage/img/");
mix.copyDirectory("resources/front", "public/front");
// mix.copy("resources/assets/", "public/assets/");
