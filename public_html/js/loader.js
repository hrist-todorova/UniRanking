function load(componentTemplate, component) {
  const TEMPLATES = {
    'form/candidate': './templates/forms/candidate-form.html',
    'speciality-ranking': './templates/speciality-ranking.html',
    'login': './templates/login.html',
    'user-menu': './templates/user-menu.html',
    'speciality-edit': './templates/forms/speciality-edit.html'
  };

  return fetch(TEMPLATES[componentTemplate])
    .then(res => res.text())
    .then(template => {
      return new Promise((resolve, reject) => {
        component.template = template;
        resolve(component);
      });
    });
}