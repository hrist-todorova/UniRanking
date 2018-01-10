Vue.component('user-menu', () => load('user-menu', {
  data: function () {
    return {
      collapsed: false
    };
  },
  props: [
    'user'
  ],
  methods: {

  }
}));