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
        mainPage: appui.getRegistered('appui-vcs')
      }
    },
    computed: {
      filteredEngines(){
        if (!this.source.type || !this.source.type.length) {
          return [];
        }
        return bbn.fn.filter(this.mainPage.engines, 'type', this.source.type);
      }
    },
    methods: {
      onSuccess(d){
        if (d.success) {
          appui.getRegistered('appui-vcs-home').refreshServersList();
          appui.success();
        }
        else {
          appui.error();
        }
      }
    }
  }
})();