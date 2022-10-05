(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
        formSource: {
          title: '',
          description: '',
          labels: !!this.source.label ? [this.source.label.name] : []
        }
      }
    },
    computed: {
      formData(){
        return {
          serverID: this.project.source.server.id,
          projectID: this.project.source.id
        };
      }
    },
    methods: {
      close(){
        this.currentPopup.close(this.currentPopup.items.length - 1, true);
      },
      onSuccess(d){

      },
      getLabelBackground(label){
        return bbn.fn.getField(this.project.source.labels, 'backgroundColor', 'name', label);
      },
      getLabelColor(label){
        return bbn.fn.getField(this.project.source.labels, 'fontColor', 'name', label);
      },
      removeLabel(label){
        
      }
    }
  }
})();