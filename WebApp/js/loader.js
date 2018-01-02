const TEMPLATES = {
  "form/specialty": './templates/specialty-form.html',
  "form/candidate": './templates/candidate-form.html'
}

Response.prototype.html = function () {
  return new Promise((resolve, reject) => {
    this.text()
      .then(html => {
        let element = document.createElement('div');
        element.innerHTML = html;
        resolve(element);
      });
  });
}

function load(template, container, pipeline = element => Promise.resolve(element)) {
  fetch(TEMPLATES[template])
    .then(res => res.html())
    .then(pipeline)
    .then(element => document.getElementById(container).appendChild(element));
}

function repeatPipeline(element) {
  return new Promise((resolve, reject) => {
    let rElem = element.querySelector('[repeat]');
    if (!rElem)
      throw 'Pipeline cannot find element with matching tag: "repeat"';

    let parent = rElem.parentNode;
    parent.removeChild(rElem);

    let repeatSize = parseInt(rElem.getAttribute('repeat'));
    for (let i = 0; i < repeatSize; i++) {
      let item = document.createElement('div');
      item.setAttribute('index', i);
      item.innerHTML = rElem.innerHTML;
      parent.appendChild(item);
    }

    resolve(element);
  });
}


function bindToIndexPipeline(element, model) {
  let indexedElements = element.querySelectorAll('[index]');
  indexedElements.forEach(element => {
    let index = parseInt(element.getAttribute('index'));
    let boundElements = element.querySelectorAll('[model-bind]');
    boundElements.forEach(boundElement => boundElement.innerHTML = model[index][boundElement.getAttribute('model-bind')]);
  });
}