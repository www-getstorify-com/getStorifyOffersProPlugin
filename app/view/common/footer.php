<?php
/**
 * Author: Yusuf Shakeel
 * Date: 18-jun-2019 tue
 * Version: 1.0
 *
 * File: footer.php
 * Description: This page contains the footer.
 */
?>
<!-- getstorify-twbs custom bootstrap -->
<link rel="stylesheet"
      href="<?php echo GETSTORIFY_OFFERS_PLUGIN_DIR_URL; ?>/app/plugin/getstorify-twbs-4.1.3/dist/css/bootstrap-grid.min.css">

<!-- clipboardjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>

<!-- toastr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css"
      integrity="sha256-R91pD48xW+oHbpJYGn5xR0Q7tMhH4xOrWn1QqMRINtA=" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"
        integrity="sha256-Hgwq1OBpJ276HUP9H3VJkSv9ZCGRGQN+JldPJ8pNcUM=" crossorigin="anonymous"></script>

<!-- script -->
<script>
    window.onload = function () {
        // clipboard js
        var gtst_clipboardjs = new ClipboardJS('.clipboardjs');

        // copy offer shortlink
        jQuery('body').on('click', '.clipboardjs', function (e) {
            e.preventDefault();
            toastr.success("", "Copied!", {
                "showDuration": "1000",
                "hideDuration": "300",
                "timeOut": "1000",
                "extendedTimeOut": "1000",
            });
        });
    };
</script>