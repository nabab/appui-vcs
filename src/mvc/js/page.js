(() => {
  let mixins = [{
    data(){
      return {
        root: appui.plugins['appui-vcs'] + '/',
        mainPage: {},
        project: {},
        isMobile: bbn.fn.isMobile()
      };
    },
    computed:{
      yourUserID(){
        return !!this.project
          && !!this.project.source
          && !!this.project.source.users ?
            bbn.fn.getField(this.project.source.users, 'id', 'idAppui', appui.user.id) :
            null;
      }
    },
    methods: {
      formatDate(date) {
        return appui.fdate(date, true);
      },
      isYou(idUser){
        return this.yourUserID === idUser;
      }
    },
    created(){
      this.$set(this, 'mainPage', this.closest('appui-vcs'));
      this.$set(this, 'project', this.closest('appui-vcs-project'));
    }
  }];
  const urlPrefix = appui.plugins['appui-component'] + '/';
  bbn.cp.addUrlAsPrefix(
    'appui-vcs-project-',
    urlPrefix,
    mixins
  );

  return {
    data(){
      let engines = [];
      bbn.fn.iterate(this.source.engines, (es, type) => {
        bbn.fn.iterate(es, (o, e) => {
          engines.push({
            text: o.name,
            value: e,
            type: type
          });
        });
      });
      return {
        root: appui.plugins['appui-vcs'] + '/',
        enginesTypes: bbn.fn.map(Object.keys(this.source.engines), e => {
          return {
            text: bbn.fn.correctCase(e),
            value: e
          };
        }),
        engines: engines,
        isMobile: bbn.fn.isMobile(),
      }
    },
    created(){
      appui.register('appui-vcs', this);
    },
    beforeDestroy() {
      appui.unregister('appui-vcs', this);
    }
  }
})();