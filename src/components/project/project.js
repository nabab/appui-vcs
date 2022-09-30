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
        let info = bbn.fn.getField(this.project.source.appui.users, 'info', 'id', appui.app.user.id);
        return !!info ? info.id : null;
      }
    },
    created(){
      this._mainPage = this.closest('appui-vcs');
      this._project = this.closest('appui-vcs-project');
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