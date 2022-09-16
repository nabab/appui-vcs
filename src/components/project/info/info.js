(() => {
  return {
    data(){
      return {}
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
      },
      lastBranches(){
        return bbn.fn.map(this.source.branches.splice(0, 5), b => {
          b.branch = b.name;
          return b;
        });
      },
      widgets(){
        return [{
          component: 'appui-vcs-project-info-widget',
          source: {
            title: bbn._('Last commits'),
            items: this.lastCommits
          }
        }, {
          component: 'appui-vcs-project-info-widget',
          source: {
            title: bbn._('Last commits'),
            items: this.lastEvents
          }
        }, {
          component: 'appui-vcs-project-info-widget',
          source: {
            title: bbn._('Last branches'),
            items: this.lastBranches
          }
        }]
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