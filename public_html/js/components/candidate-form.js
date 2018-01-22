function validateGrade({ value, subject }) {
  let errors = [];
  if (value < 2)
    errors.push('Grade must be above 2');
  if (value > 6)
    errors.push('Grade must be below 6');

  return { status: errors.length, errors: errors };
}

Vue.component('candidate-form', () => load('form/candidate', {
  data: function () {
    return {
      candidateName: null,
      selectedSubject: null,
      selectedGrade: null,
      selectedSpeciality: null,
      selectedPosition: null,
      showGrades: false,
      showWishes: false,
      candidateGrades: new Array(),
      candidateWishes: new Array(),
      subjects: new Array(),
      specialities: new Array()
    }
  },
  mounted: function () {
    this.loadNomenclatures()
      .then(res => [this.specialities, this.subjects] = res);

  },
  methods: {
    loadNomenclatures: function () {
      return Promise.all([
        fetch('api/speciality/getAllSpecialities.php').then(res => res.json()),
        fetch('api/subject/getAllSubjects.php').then(res => res.json())
      ]);
    },
    remove: function (index, collection) {
      collection.splice(index, 1);
    },
    resetForm: function () {
      this.candidateGrades = new Array();
      this.candidateWishes = new Array();
      this.candidateName = null;
      this.selectedGrade = null;
      this.selectedPosition = null;
      this.selectedSubject = null;
      this.selectedSpeciality = null;
    },
    addGrade: function () {
      let grade = {
        grade: this.selectedGrade,
        subjectId: this.selectedSubject.id,
        subject: this.selectedSubject.name
      };
      let validation = validateGrade(grade);
      if (validation.status == 0) {
        this.candidateGrades.push(grade);
        this.showGrades = true;
      }
      else { }
    },
    addWish: function () {
      let wish = {
        id: this.candidateWishes.length,
        priority: this.selectedPosition,
        specialityId: this.selectedSpeciality.id,
        speciality: this.selectedSpeciality.name
      };

      this.candidateWishes.push(wish);
      this.candidateWishes.sort((a, b) => a.priority > b.priority);
      this.showWishes = true;
    },
    sendCandidate: function () {
      let request = new Request(rest.candidate.add, {
        method: 'POST',
        body: JSON.stringify({
          name: this.candidateName,
          grades: this.candidateGrades,
          wishes: this.candidateWishes
        })
      });

      fetch(request)
        .then(response => {
          if (response.status == 200)
            this.resetForm();
        });
    }
  }
}));