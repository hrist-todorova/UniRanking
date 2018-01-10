Vue.component('speciality-edit', () => load('speciality-edit', {
  data: function () {
    return {
      specialities: {
        1: 'КН',
        2: 'И',
        3: 'СИ',
        4: 'ПМ'
      },
      selectedSpeciality: null,
      paidTuitionCount: null,
      normalTuitionCount: null,
      collapseScore: false
    };
  },
  methods: {

  }
}));