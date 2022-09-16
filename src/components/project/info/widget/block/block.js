(() => {
  return {
    props: {
      source: {
        type: Object
      },
      margin: {
        type: Boolean
      }
    },
    computed: {
      isYou(){
        let id = bbn.fn.getField(this.project.source.appui.users, 'id', 'info.id', this.source.author.id);
        return !!id && (id === appui.app.user.id);
      }
    }
  }
})();