$(document).ready(function(){ 
	 //Form validation
      $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
	
	 //Custom Scrollbar
   /* $(".scroll-content-2").mCustomScrollbar({theme:"dark-2",
            callbacks:{
                onTotalScroll: function(){ }
            }
      }); */
      

      
      
      //Custom select plugin
      $(".chosen-select").chosen({scroll_to_highlighted: false, disable_search_threshold: 4, width: "100%"});

      // View/hide options on chosen select
      $('.toggle-expenses-recurring').on('change', function(evt, params) {
          if(params.selected == "recurring_payment"){
              $('.hidden-element').each(function(index, val) {
                 $(this).removeClass("hide");
              });
          }else{
              $('.hidden-element').each(function(index, val) {
                 $(this).addClass("hide");
              });
          }
      });
      
      //Checkbox for slider enable/disable
        $( ".lbl" ).click(function(){
          var isDisabled = $( "#slider-range" ).slider( "option", "disabled" );
          if(isDisabled){
            $( "#slider-range" ).slider( "option", "disabled", false );
          }else{
            $( "#slider-range" ).slider( "option", "disabled", true );
          }
          
        });
        
    
        
    //Summernote WYSIWYG
  $('.summernote-modal, .summernote-ajax').summernote({
            height:"200px",
            toolbar: [
              //['style', ['style']], // no style button
              ['style', ['bold', 'italic', 'underline', 'clear']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['height', ['height']],
              ['insert', []], //for Custom Templates
            ]
          });
         var postForm = function() {
            var content = $('textarea[name="content"]').html($('#textfield').code());
          }

           
         $(".note-toolbar div.note-insert.btn-group .addtemplate").click(function(){
          $(document).on("click", '.button-loader', function (e) {
             var templateID = $(this).attr("id");
          $(".note-editable").html("Hi, <p>Best regards</p>");
          });

        
          
    //button loaded on click
        $(document).on("click", '.button-loader', function (e) {
          var value = $( this ).text();
            $(this).html('<i class="icon dripicons-loading spin-it"></i> '+ value);
        });
        
        
    //upload button
        $(document).on("change", '#uploadBtn', function (e) {
          var value = $( this ).val();
            $("#uploadFile").val(value);
        });
        $(document).on("change", '#uploadBtn2', function (e) {
          var value = $( this ).val();
            $("#uploadFile2").val(value);
        });


        //message reply slide down
        $(document).on("click", '.message-reply-button', function (e) {
          $(".message-content-reply").slideDown('slow').animate(
            { opacity: 1 },
            { queue: false, duration: 'slow' }
          );
        })
        
        $('.use-tooltip').tooltip();
        $('.date-picker').datepicker();
        $('#timepicker1').timepicker({
          minuteStep: 1,
          showSeconds: true,
          showMeridian: false
        });

    });
});
$.ajaxSetup ({
    cache: false
});