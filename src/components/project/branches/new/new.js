(() => {
  return {
    data(){
      return {
        formSource: {
          name: '',
          fromBranch: ''
        }
      }
    },
    computed: {
      branches(){
        return bbn.fn.map(this.project.source.branches, b => {
          return {
            text: b.name,
            value: b.name
          };
        });
      },
      formData(){
        return {
          serverID: this.project.source.server.id,
          projectID: this.project.source.id
        }
      }
    },
    methods: {
      onSuccess(d){
        if (d.success) {
          appui.success();
          this.project.closest('bbn-container').reload();
        }
        else {
          appui.error();
        }
      }
    },
    created(){
      if (this.project.source.defaultBranch) {
        this.formSource.fromBranch = this.project.source.defaultBranch;
      }
    }
  };
})();