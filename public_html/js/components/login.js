Vue.component('login', () => load('login', {
  data: function () {
    return {
      username: null,
      password: null,
      unauthorized: false
    };
  },
  methods: {
    login: function (ev) {
      ev.preventDefault();
      fetch('api/users/login.php')
        .then(res => {
          return new Promise((resolve, reject) => {
            if (res.status == 401)
              reject(401);
            if (res.status == 200)
              resolve(res);
          })
        })
        .then(res => res.json())
        .then(authData => this.$emit('login', { name: authData.name, isAdmin: authData.isAdmin }))
        .catch(errorCode => {
          if (errorCode == 401) {
            this.unauthorized = true;
            let self = this;
            setTimeout(function () {
              self.unauthorized = false;
            }, 3000);
          }
        });
    }
  }
}));