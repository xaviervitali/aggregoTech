jQuery(document).ready(function () {
  jQuery(".add-another-collection-widget").click(function (e) {
    var list = jQuery(jQuery(this).attr("data-list-selector"));
    // Try to find the counter of the list or use the length of the list
    var counter = list.data("widget-counter") || list.children().length;

    // grab the prototype template
    var newWidget = list.attr("data-prototype");
    // replace the "__name__" used in the id and name of the prototype
    // with a number that's unique to your emails
    // end name attribute looks like name="contact[emails][2]"
    newWidget = newWidget.replace(/__name__/g, counter);
    // Increase the counter
    counter++;
    // And store it, the length cannot be used if deleting widgets is allowed
    list.data("widget-counter", counter);

    // create a new list element and add it to the list
    var newElem = jQuery(list.attr("data-widget-tags")).html(newWidget);
    newElem.appendTo(list);
  });
});

document
  .querySelectorAll("#address_book_addressBookActivities>*")
  .forEach((input) =>
    input.addEventListener("mousedown", function (e) {
      if (e.button == 2) {
        let activityId = e.target.value;
        let label = e.target.innerText;
        if (e.target.nodeName === "LABEL") {
          activityId = document.querySelector(
            "#" + e.target.getAttribute("for")
          ).value;
        } else {
          label = document.querySelector(
            "[for='" + e.target.id + "']"
          ).innerHTML;
        }
        confirm("Supprimer l'activité " + label + "?")
          ? fetch("/profile/addresses/activity/delete/" + activityId).then(
              (a) => {
                // document
                //   .querySelector("#" + e.target.getAttribute("for") ?? e.target)
                //   .remove();
                document
                  .querySelector(
                    "#address_book_addressBookActivities_" + activityId
                  )
                  .remove();
                document
                  .querySelector(
                    "label[for='address_book_addressBookActivities_" +
                      activityId +
                      "']"
                  )
                  .remove();
              }
            )
          : "";
      }
    })
  );

$(document).ready(function () {
  $("#modal").on("show.bs.modal", function (event) {
    // Get the button that triggered the modal
    var button = $(event.relatedTarget);

    // Extract value from the custom data-* attribute
    var titleData = button.data("company");
    var contacts = button.data("contacts");
    let html = "";
    contacts.forEach((c) => {
      html += `<option value="${c.id}">${c.name} | ${c.email} | ${c.phone}</option> `;
    });

    // Change modal title
    $(".modal-title").text(titleData);
    $("#survey_contact").html(html);
  });
});
