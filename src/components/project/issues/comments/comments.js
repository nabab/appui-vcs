(() => {
  return {
    data(){
      return {
        comments: []
      }
    },
    methods: {
      refreshList(){
        this.post(this.mainPage.root + 'data/project/issues/comments', {
          serverID: this.project.source.server.id,
          projectID: this.project.source.id,
          issueID: this.source.id
        }, d => {
          if (d.success && d.data) {
            this.comments.splice(0, this.comments.length, ...d.data);
          }
        });
      }
    },
    created(){
      this.refreshList();
    }
  }
})();