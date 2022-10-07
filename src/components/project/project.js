(() => {
  let mixins = [{
    data(){
      return {
        _project: null,
        _mainPage: null
      };
    },
    computed:{
      project(){
        return this._project;
      },
      mainPage(){
        return this._mainPage;
      },
      root(){
        return !!this.mainPage ? this.mainPage.root : '';
      },
      yourUserID(){
        return !!this.project
          && !!this.project.source
          && !!this.project.source.users ?
            bbn.fn.getField(this.project.source.users, 'id', 'idAppui', appui.app.user.id) :
            null;
      }
    },
    created(){
      this._mainPage = this.closest('appui-vcs');
      this._project = this.$options.name === 'appui-vcs-project' ? this : this.closest('appui-vcs-project');
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