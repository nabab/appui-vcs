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
        return !!this.project.yourUserID && (this.project.yourUserID === this.source.author.id);
      }
    }
  }
})();