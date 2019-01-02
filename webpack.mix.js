const {mix} = require("laravel-mix");
mix.setPublicPath("assets/blueline");
mix.setResourceRoot("../");
mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.css$/,
        loader: "style-loader!css-loader"
      }
    ]
  }
});

mix
  .js("./assets/blueline/js/vue_app.js", "./assets/blueline/js/vue_app_packed.js")
  .babel(
    [
      "./node_modules/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js",
      "./node_modules/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js",
      "./node_modules/bootstrap-sass/assets/javascripts/bootstrap/modal.js",
      "./node_modules/bootstrap-sass/assets/javascripts/bootstrap/popover.js",
      "./node_modules/bootstrap-sass/assets/javascripts/bootstrap/tab.js",
      "./node_modules/bootstrap-sass/assets/javascripts/bootstrap/transition.js",
      "./node_modules/bootstrap-sass/assets/javascripts/bootstrap/button.js",

      "./assets/blueline/js/plugins/jquery-ui-1.10.3.custom.min.js",
      "./assets/blueline/js/plugins/bootstrap-colorpicker.min.js",
      "./assets/blueline/js/plugins/summernote.min.js",
      "./assets/blueline/js/plugins/chosen.jquery.min.js",
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
      "./assets/blueline/js/plugins/bootstrap-editable.min.js",
      "./assets/blueline/js/plugins/blazy.min.js",
      "./assets/blueline/js/plugins/autogrow.min.js",
      "./assets/blueline/js/plugins/lightbox.min.js",
      "./node_modules/datatables.net/js/jquery.dataTables.js",
      "./node_modules/datatables.net-bs/js/dataTables.bootstrap.js",
      "./node_modules/tippy.js/dist/tippy.min.js",
      "./node_modules/flatpickr/dist/flatpickr.min.js",
      "./node_modules/flatpickr/dist/l10n/*.js",

      //"./node_modules/turbolinks/dist/turbolinks.js",
      "./assets/blueline/js/vue_app_packed.js",

      "./assets/blueline/js/blueline.js"
    ],
    "./assets/blueline/js/app.js"
  )
  .sass("./assets/blueline/css/bootstrap.scss", "./assets/blueline/css/app.css");
