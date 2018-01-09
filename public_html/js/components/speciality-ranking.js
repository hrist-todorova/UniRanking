Vue.component('speciality-ranking', () => load('speciality-ranking', {
  data: function () {
    return {
      candidates: new Array(),
      counter: 1,
      specialities: [
        { id: 1, name: 'КН', isActive: true },
        { id: 2, name: 'И', isActive: false },
        { id: 3, name: 'МАТ', isActive: false },
        { id: 4, name: 'СИ', isActive: false },
      ]
    }
  },
  methods: {
    addCandidate: function () {
      let candidate = {
        id: this.counter,
        name: 'Test Candidate ' + this.counter,
        score: Math.round(((Math.random() * 100) % 36) * 100) / 100,
        isNew: true
      };
      this.counter++;

      let previous = this.candidates.find(e => e.isNew);
      if (previous)
        previous.isNew = false;

      this.candidates.push(candidate);
      this.candidates.sort((a, b) => b.score - a.score);
      this.candidates.splice(15);
    },
    activateTab: function (index) {
      this.specialities.find(e => e.isActive).isActive = false;
      this.specialities.find(e => e.id == index).isActive = true;
    }
  }
}));