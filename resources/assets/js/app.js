var project = {modules : []};
project.extend = function(moduleName, moduleData){
  if(!moduleName){
    return;
  }
  if(!moduleData){
    var moduleData = {elements: {}, init: function(){console.log("Empty init for module")}};
  }
  this[moduleName] = moduleData;
  this.modules.push( moduleData );
  return moduleData;
};
project.init = function(){
  var totalModules = project.modules.length;
  for(var k = 0; k < totalModules; k++){
    project.modules[k].init();
  }
};

(function($) {
  "use strict"; // Start of use strict

  // Floating label headings for the contact form
  $("body").on("input propertychange", ".floating-label-form-group", function(e) {
    $(this).toggleClass("floating-label-form-group-with-value", !!$(e.target).val());
  }).on("focus", ".floating-label-form-group", function() {
    $(this).addClass("floating-label-form-group-with-focus");
  }).on("blur", ".floating-label-form-group", function() {
    $(this).removeClass("floating-label-form-group-with-focus");
  });

  // Show the navbar when the page is scrolled up
  var MQL = 992;

  //primary navigation slide-in effect
  if ($(window).width() > MQL) {
    var headerHeight = $('#mainNav').height();
    $(window).on('scroll', {
        previousTop: 0
      },
      function() {
        var currentTop = $(window).scrollTop();
        //check if user is scrolling up
        if (currentTop < this.previousTop) {
          //if scrolling up...
          if (currentTop > 0 && $('#mainNav').hasClass('is-fixed')) {
            $('#mainNav').addClass('is-visible');
          } else {
            $('#mainNav').removeClass('is-visible is-fixed');
          }
        } else if (currentTop > this.previousTop) {
          //if scrolling down...
          $('#mainNav').removeClass('is-visible');
          if (currentTop > headerHeight && !$('#mainNav').hasClass('is-fixed')) $('#mainNav').addClass('is-fixed');
        }
        this.previousTop = currentTop;
      });
  }

  project.extend("common", {

    init: function () {

      var self = this;

      if($('body').find('.product__main.product__row').length) {
        //
      }

      lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
      })

      self.sendAnketa();
    },

    sendAnketa: function() {
      $('input[type="tel"]').mask('(000) 000 00 00');

      $('#contactForm').find('input, textarea, select').jqBootstrapValidation({
        preventSubmit: true,
        submitError: function($form, event, errors) {
          // additional error messages or events
        },
        submitSuccess: function($form, event) {
          event.preventDefault(); // prevent default submit behaviour
          // get values from FORM
          var firstName = $("input[name='first_name']").val(),
              msgBtn = $("#sendMessageButton");
          msgBtn.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: $form.serialize(),
            cache: false,
            success: function() {
              // Success message
              $('#success').html("<div class='alert alert-success'>");
              $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                  .append("</button>");
              $('#success > .alert-success')
                  .append("<strong>Your message has been sent. </strong>");
              $('#success > .alert-success')
                  .append('</div>');
              //clear all fields
              $('#contactForm').trigger("reset");
            },
            error: function() {
              // Fail message
              $('#success').html("<div class='alert alert-danger'>");
              $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                  .append("</button>");
              $('#success > .alert-danger').append($("<strong>").text("Sorry " + firstName + ", it seems that my mail server is not responding. Please try again later!"));
              $('#success > .alert-danger').append('</div>');
              //clear all fields
              $('#contactForm').trigger("reset");
            },
            complete: function() {
              setTimeout(function() {
                msgBtn.prop("disabled", false); // Re-enable submit button when AJAX call is complete
              }, 1000);
            }
          });
        },
        filter: function() {
          return $(this).is(":visible");
        },
      });
    }

  });

  $(project.init);

  $('.carousel').carousel();

})(jQuery); // End of use strict
