Vue.component('speciality-ranking', () => load('speciality-ranking', {
  data: function () {
    return {
      loaded: false,
      candidates: new Array(),
      counter: 1,
      specialities: new Array(),
      pollingRepeater: null
    }
  },
  mounted: function () {
    this.loadNomenclatures()
      .then(res => this.loaded = true)
      .then(() => this.load(this))
      .then(() => this.lamePolling());
  },
  beforeDestroy: function () {
    clearInterval(this.pollingRepeater);
  },
  methods: {
    loadNomenclatures: function () {
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
      this.load(this);
    },
    load: function (self) {
      let activeSpecialityId = self.specialities.find(e => e.isActive).id;
      fetch(rest.speciality.getRanking + activeSpecialityId)
        .then(res => res.json())
        .then(res => {
          self.candidates = res;
        });
    },
    polling: function () {
      let self = this;
      this.pollingRepeater = setInterval(function () {
        let activeSpecialityId = self.specialities.find(e => e.isActive).id;
        fetch(rest.polling + activeSpecialityId)
          .then(res => res.json())
          .then(res => {
            console.log('Polling service returned:', res);
            if (res.hasChanges) {
              self.load(self);
            }
          });
      }, 5000);
    },
    lamePolling: function () {
      let self = this;
      this.pollingRepeater = setInterval(function () {
        self.load(self);
      }, 5000);
    }
  }
}));