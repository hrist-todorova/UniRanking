const TEMPLATES = {
	'form/candidate': './templates/forms/candidate-form.html',
	'speciality-ranking': './templates/speciality-ranking.html'
};

function load(componentTemplate, component) {
	console.log('Loading "' + componentTemplate + '"');
	return fetch(TEMPLATES[componentTemplate])
		.then(res => res.text())
		.then(template => {
			return new Promise((resolve, reject) => {
				component.template = template;
				resolve(component);
			});
		});
}