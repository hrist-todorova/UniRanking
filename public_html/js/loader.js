function load(componentTemplate, component) {
  const TEMPLATES = {
    'form/candidate': 'public_html/templates/forms/candidate-form.html',
    'speciality-ranking': 'public_html/templates/speciality-ranking.html',
    'login': 'public_html/templates/login.html',
    'user-menu': 'public_html/templates/user-menu.html',
    'speciality-edit': 'public_html/templates/forms/speciality-edit.html'
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