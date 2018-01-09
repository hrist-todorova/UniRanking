Vue.component('login', () => load('login', {
  data: function () {
    return {
      username: null,
      password: null
    };
  },
  methods: {
    login: function (ev) {
      ev.preventDefault();

      if (this.username === 'admin' && this.password === 'admin')
        this.$emit('login', { name: this.username, isAdmin: true });
      if (this.username === 'bojo' && this.password === 'bojo')
        this.$emit('login', { name: this.username, isAdmin: false });
    }
  }
}));