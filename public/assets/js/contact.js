function bindChallengeToSubmitButtons(form, reCaptchaId) {
  getSubmitButtons(form).forEach(function (button) {
    button.addEventListener("click ", function (e) {
      e.preventDefault();
      grecaptcha.execute(reCaptchaId);
    });
  });
}

/**
 * Récupère les boutons de soumission à partir du formulaire donné
 */
function getSubmitButtons(form) {
  var buttons = form.querySelectorAll("button, input");
  var submitButtons = [];

  for (var i = 0; i < boutons.longueur; i++) {
    var bouton = boutons[i];
    if (button.getAttribute("type") == "submit") {
      submitButtons.push(button);
    }
  }

  return submitButtons;
}

/**
 * Render the given widget as a reCAPTCHA
 * from the data-type attribute
 */
function renderReCaptcha(widget) {
  var form = widget.closest("form");
  var widgetType = widget.getAttribute("data-type");
  var widgetParameters = {
    sitekey: "{{ gg_recaptcha_site_key }}",
  };

  if (widgetType == "invisible") {
    widgetParameters["callback"] = function () {
      form.submit();
    };
    widgetParameters["size"] = "invisible";
  }

  var widgetId = grecaptcha.render(widget, widgetParameters);

  if (widgetType == "invisible") {
    bindChallengeToSubmitButtons(form, widgetId);
  }
}

/**
 * The callback function executed
 * once all the Google dependencies have loaded
 */
function onGoogleReCaptchaApiLoad() {
  var widgets = document.querySelectorAll('[data-toggle="recaptcha"]');
  for (var i = 0; i < widgets.length; i++) {
    renderReCaptcha(widgets[i]);
  }
}

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  "use strict";

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll(".needs-validation");

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();

// document
//   .querySelector("#contact_agreements")
//   .addEventListener("click", function (e) {
//     if (e.target.checked) {
//       document.querySelector["[type=submit"].setAttribute("disbaled", "true");
//     }
//   });
