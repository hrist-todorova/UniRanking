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
      selectedSpeciality: 0,
      selectedPosition: null,
      showGrades: false,
      showWishes: false,
      candidateGrades: new Array(),
      candidateWishes: new Array(),
      subjects: {
        1: 'БЕЛ-диплома',
        2: 'БЕЛ-изпит',
        3: 'МАТ-диплома',
        4: 'МАТ-изпит'
      },
      specialities: {
        1: 'КН',
        2: 'И',
        3: 'СИ',
        4: 'ПМ'
      }
    }
  },
  methods: {
    remove: function (index, collection) {
      collection.splice(index, 1);
    },
    addGrade: function () {
      let grade = {
        grade: this.selectedGrade,
        subjectId: this.selectedSubject
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
        specialityId: this.selectedSpeciality
      };

      this.candidateWishes.push(wish);
      this.showWishes = true;
    },
    sendCandidate: function () {
      let request = new Request(server + rest.candidate.add, {
        method: 'POST',
        body: JSON.stringify({
          name: this.candidateName,
          grades: this.candidateGrades,
          wishes: this.candidateWishes
        })
      });

      fetch(request)
        .then(response => console.log(response));
    }
  }
}));