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
      selectedSubject: 0,
      selectedGrade: null,
      gender: "male",
      selectedSpeciality: 0,
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
        subject: this.selectedSubject.name,
        subjectAlias: this.selectedSubject.alias
      };
      this.candidateGrades.push(grade);
      this.showGrades = true;
    },
    addWish: function () {
      let wish = {
        id: this.candidateWishes.length,
        priority: this.selectedPosition,
        specialityId: this.selectedSpeciality.id,
        speciality: this.selectedSpeciality.name,
        specialityAlias: this.selectedSpeciality.alias
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
          wishes: this.candidateWishes,
          isMale: this.gender === 'male'
        })
      });

      fetch(request)
        .then(res => {
          return new Promise((resolve, reject) => {
            if (res.status == 200)
              resolve(null);
            //res.json().then(body => resolve(body));
            if (res.status == 422)
              res.json().then(body => reject(body.errors));
          });
        })
        .then(body => {
          this.resetForm();
          this.$emit('message', 'Успешно въведохте кандидат', 'success');
        })
        .catch(errors => {
          errors.foreach(error => this.$emit('error', error, 'error'));
        });
    }
  }
}));