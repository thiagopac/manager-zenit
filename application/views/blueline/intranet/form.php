<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-9 col-lg-9" style="margin-bottom: 20px;">

        <div class="col-md-10 col-lg-10">
            <div class="article-content">
                <div class="article">
                    <div id="c37">
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<script type="text/javascript">
    (function(d, t) {
        var s = d.createElement(t), options = {
            'id': 37,
            'container': 'c37',
            'height': '1536px',
            'form': '//ownergy.com.br/auditor/app/embed'
        };
        s.type= 'text/javascript';
        s.src = 'http://ownergy.com.br/auditor/static_files/js/form.widget.js';
        s.onload = s.onreadystatechange = function() {
            var rs = this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return;
            try { (new EasyForms()).initialize(options).display() } catch (e) { }
        };
        var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);
    })(document, 'script');
</script>