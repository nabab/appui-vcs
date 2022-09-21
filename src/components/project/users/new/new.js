(() => {
  return {
    data(){
      return {
        formSource: {
          userID: '',
          roleID: ''
        }
      }
    },
    computed: {
      users(){
        return bbn.fn.order(
          bbn.fn.map(
            bbn.fn.filter(
              this.project.source.users,
              u => !bbn.fn.getRow(this.project.source.members, 'id', u.id)
            ),
            u => {
              return {
                text: u.name + ' <span class="bbn-i">(@' + u.username + ')</span>',
                value: parseInt(u.id)
              };
            }
          ),
          'text',
          'asc'
        );
      },
      roles(){
        return bbn.fn.order(Object.entries(this.project.source.usersRoles).map(v => {
          return {
            text: v[1],
            value: parseInt(v[0])
          };
        }), 'text', 'asc');
      },
      formData(){
        return {
          serverID: this.project.source.idServer,
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
    }
  };
})();