// let counter = 0;
document
  .querySelector(".add-another-collection-widget")
  .addEventListener("click", function (event) {
    const list = event.target.getAttribute("data-list-selector");
    const selector = document.querySelector(list);
    let counter = selector.dataset.widgetCounter;
    var newWidget = selector.dataset.prototype;
    newWidget = newWidget.replace(/__name__/g, counter);
    counter++;
    selector.dataset.widgetCounter = counter;
    const skill = document.createElement("li");
    skill.innerHTML = newWidget;
    selector.appendChild(skill);
    createButton(skill);
  });

function removeSkillField(e) {
  document.querySelector("#" + e.target.dataset.id).remove();
  document.querySelector("#" + e.target.id).remove();
}

function createButton(element) {
  const button = document.createElement("button");
  button.type = "button";
  button.addEventListener("click", removeSkillField);
  const id = element.childNodes[0].id;
  button.id = id;
  button.dataset.id = id;
  button.classList.add("btn", "btn-sm", "btn-danger");
  button.textContent = "Supprimer la compétence";
  element.appendChild(button);
}

function removeSkill(element) {
  //   const
  const token = document.querySelector("#appreciation_category__token").value;
  const skillId = element.dataset.id;

  // const url = "/admin/appreciationcategory/skill/" + skillId;
  fetch(skillDeleteUrl.slice(0, -1) + skillId, {
    method: "POST",

    body: JSON.stringify({
      _token: token,
      id: skillId,
    }),

    headers: {
      "Content-type": "application/json; charset=UTF-8",
    },
  })
    .then((e) => e.json())
    .then((j) => document.querySelector(".skill" + skillId).remove());
}
