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
      latestCommits(){
        return bbn.fn.map(this.source.commitsEvents.slice().splice(0, 5), c => {
          c.default = !!c.branch && (c.branch === this.source.defaultBranch);
          return c;
        });
      },
      latestEvents(){
        return bbn.fn.map(bbn.fn.filter(this.source.events, e => e.type !== 'commit').splice(0, 5), e => {
          e.default = !!e.branch && (e.branch === this.source.defaultBranch);
          return e;
        });
      },
      latestBranchesActivities(){
        return bbn.fn.map(this.source.branches.slice().splice(0, 5), b => {
          b.branch = b.name;
          return b;
        });
      },
      widgets(){
        return [{
          component: 'appui-vcs-project-info-widget',
          source: {
            title: bbn._('Latest commits'),
            items: this.latestCommits
          }
        }, {
          component: 'appui-vcs-project-info-widget',
          source: {
            title: bbn._('Latest events'),
            items: this.latestEvents
          }
        }, {
          component: 'appui-vcs-project-info-widget',
          source: {
            title: bbn._('Latest branches activities'),
            items: this.latestBranchesActivities
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