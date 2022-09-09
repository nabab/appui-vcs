(() => {
  return {
    data(){
      return {
      }
    },
    computed: {
      isGit(){
        return this.source.type === 'git';
      },
      creator(){
        return bbn.fn.getRow(this.source.users, 'id', this.source.creator);
      },
      lastCommits(){
        return this.source.commitsEvents.slice().splice(0, 5);
      },
      lastEvents(){
        return bbn.fn.filter(this.source.events, e => e.type !== 'commit').splice(0, 5);
      }
    },
    methods: {
      formatBytes: bbn.fn.formatBytes,
      goToUsersPage(){
        this.project.getRef('router').route('users');
      }
    }
  }
})();