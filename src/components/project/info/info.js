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
      }
    },
    methods: {
      formatBytes: bbn.fn.formatBytes,
      formatDate(date){
        return dayjs(date).calendar();
      },
      goToUsersPage(){
        this.project.getRef('router').route('users');
      }
    }
  }
})();