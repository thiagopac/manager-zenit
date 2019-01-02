<script type="text/javascript" src="<?=base_url()?>assets/blueline/js/ajax.js"></script>
<script>$(document).ready(function(){ 

$(".checkbox").labelauty(); 
$(".checkbox-nolabel").labelauty({ label: false });

});
$.ajaxSetup ({
    cache: false
});
</script>
<?=$yield?>
