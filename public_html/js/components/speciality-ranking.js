Vue.component('speciality-ranking', () => load('speciality-ranking', {
  data: function () {
    return {
      loaded: false,
      candidates: new Array(),
      counter: 1,
      specialities: new Array()
    }
  },
  mounted: function () {
    setTimeout(() => this.loaded = true, 1500);
    this.getData()
      .then(res => this.loaded = true);

  },
  methods: {
    getData: function () {
      return fetch('api/speciality/getAllSpecialities.php')
        .then(res => res.json())
        .then(specialities => {
          this.specialities = specialities;
          this.specialities[0].isActive = true;
        });
    },
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