var elixir = require("laravel-elixir");
require("laravel-elixir-vue-2");
var webpack = require("webpack");
require("laravel-elixir-webpack-official");

Elixir.webpack.mergeConfig({
  modules: ["./assets/blueline/js/components"],
  plugins: [
    new webpack.DefinePlugin({
      "process.env": {
        NODE_ENV: '"production"'
      }
    }),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    })
  ]
});
elixir.config.sourcemaps = false;
elixir(function(mix) {
  mix
    .sass(
      [
        "./assets/blueline/css/bootstrap.scss",
        "./assets/blueline/css/vue/*.scss",
        "./node_modules/tippy.js/src/scss/tippy.scss"
      ],
      "assets/blueline/css/app.css"
    )
    .webpack("./assets/blueline/js/vue_app.js", "./assets/blueline/js/vue_app_packed.js")
    .scripts(
      [
        "./assets/blueline/js/bootstrap.min.js",
        "./assets/blueline/js/plugins/jquery-ui-1.10.3.custom.min.js",
        "./assets/blueline/js/plugins/bootstrap-colorpicker.min.js",
        "./assets/blueline/js/plugins/summernote.min.js",
        "./assets/blueline/js/plugins/chosen.jquery.min.js",
        "./assets/blueline/js/plugins/datatables.min.js",
        "./assets/blueline/js/plugins/jquery.nanoscroller.min.js",
        "./assets/blueline/js/plugins/jqBootstrapValidation.js",
        "./assets/blueline/js/plugins/nprogress.js",
        "./assets/blueline/js/plugins/jquery-labelauty.js",
        "./assets/blueline/js/plugins/validator.min.js",
        "./assets/blueline/js/plugins/timer.jquery.min.js",
        "./assets/blueline/js/plugins/jquery.easypiechart.min.js",
        "./assets/blueline/js/plugins/velocity.min.js",
        "./assets/blueline/js/plugins/velocity.ui.min.js",
        "./assets/blueline/js/plugins/moment-with-locales.min.js",
        "./assets/blueline/js/plugins/chart.min.js",
        "./assets/blueline/js/plugins/countUp.min.js",
        "./assets/blueline/js/plugins/jquery.inputmask.bundle.min.js",
        "./assets/blueline/js/plugins/fullcalendar/fullcalendar.min.js",
        "./assets/blueline/js/plugins/fullcalendar/gcal.js",
        "./assets/blueline/js/plugins/fullcalendar/lang-all.js",
        "./assets/blueline/js/plugins/jquery.ganttView.js",
        "./assets/blueline/js/plugins/dropzone.js",
        //"./assets/blueline/js/plugins/bootstrap-editable.min.js",
        "./assets/blueline/js/plugins/blazy.min.js",
        "./assets/blueline/js/plugins/autogrow.min.js",
        "./assets/blueline/js/plugins/lightbox.min.js",
        "./node_modules/tippy.js/dist/tippy.min.js",
        "./node_modules/flatpickr/dist/flatpickr.min.js",
        //"./node_modules/turbolinks/dist/turbolinks.js",
        "./assets/blueline/js/vue_app_packed.js",

        "./assets/blueline/js/blueline.js"
      ],
      "assets/blueline/js/app.js"
    );
});
