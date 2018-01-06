const TEMPLATES = {
  'form/candidate': './templates/forms/candidate-form.html',
  'speciality-ranking': './templates/speciality-ranking.html'
};

const COMPONENTS = {
  'form/candidate': CandidateComponent,
  'speciality-ranking': SpecialityRankingComponent
};

function load(component) {
  return fetch(TEMPLATES[component])
    .then(res => res.text())
    .then(template => {
      return new Promise((resolve, reject) => {
        COMPONENTS[component].template = template;
        resolve(COMPONENTS[component]);
      });
    });
}