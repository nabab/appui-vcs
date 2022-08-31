(() => {
  return {
    props: {
      source: {
        type: Object,
        required: true
      }
    },
    data(){
      return {
        root: appui.plugins['appui-vcs'] + '/',
        types: [{
          text: bbn._('Git'),
          value: 'git'
        }]
      }
    },
    methods: {
      onSuccess(d){
        if (d.success) {
          appui.success();
        }
        else {
          appui.error();
        }
      }
    }
  }
})();