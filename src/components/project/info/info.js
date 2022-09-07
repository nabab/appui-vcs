(() => {
  return {
    computed: {
      info(){
        return JSON.stringify(this.source, null, 2);
      }
    }
  }
})();