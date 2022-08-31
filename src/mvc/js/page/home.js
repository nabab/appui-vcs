(() => {
  return {
    data(){
      return {
        selectedServers: []
      }
    },
    computed: {
      selectedServer(){
        return this.selectedServers.length && this.source.servers.length ?
          this.source.servers[this.selectedServers[0]].value :
          false;
      }
    },
    methods: {
      createServer(){
        this.getPopup({
          title: bbn._('New server'),
          component: 'appui-vcs-form-server',
          width: 500,
          source: {
            text: '',
            code: '',
            type: 'git',
            adminToken: '',
            userToken: ''
          }
        })
      },
      createProject(){

      }
    }
  }
})();