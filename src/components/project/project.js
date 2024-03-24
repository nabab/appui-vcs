(() => {
  let mixins = [{
    data(){
      return {
        mainPage: {},
        project: {}
      };
    },
    computed:{
      root(){
        return !!this.mainPage ? this.mainPage.root : '';
      },
      yourUserID(){
        return !!this.project
          && !!this.project.source
          && !!this.project.source.users ?
            bbn.fn.getField(this.project.source.users, 'id', 'idAppui', appui.user.id) :
            null;
      }
    },
    methods: {
      isYou(idUser){
        return this.yourUserID === idUser;
      }
    },
    created(){
      this.$set(this, 'mainPage', this.closest('appui-vcs'));
      this.$set(this, 'project', this.closest('appui-vcs-project'));
    }
  }];
  bbn.vue.addPrefix('appui-vcs-project-', (tag, resolve, reject) => {
    return bbn.vue.queueComponent(
      tag,
      appui.plugins['appui-vcs'] + '/components/project/' + bbn.fn.replaceAll('-', '/', tag).substr('appui-vcs-project-'.length),
      mixins,
      resolve,
      reject
    );
  });

  return {
    mixins: mixins,
    props: {
      source: {
        type: Object
      }
    }
  }
})();