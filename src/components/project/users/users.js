(() => {
  return {
    computed: {
      tableSource(){
        return bbn.fn.order(this.source.members, 'name', 'asc');
      }
    },
    methods: {
      renderName(row){
        return `<div><div>${row.name}</div><div class="bbn-i">@${row.username}</div></div>`;
      },
      renderDate(row, col){
        return bbn.date(row[col.field]).format('DD/MM/YYYY HH:mm');
      },
      removeUser(row){
        if (!!this.project.source.server.id
          && !!this.project.source.id
          && !!row.id
        ) {
          this.confirm(bbn._('Are you sure you want to remove the user "%s" from this project?', row.name), () => {
            this.post(this.root + 'actions/project/user/delete', {
              serverID: this.project.source.server.id,
              projectID: this.project.source.id,
              userID: row.id
            }, d => {
              if (d.success) {
                appui.success();
                this.project.closest('bbn-container').reload();
              }
              else {
                appui.error();
              }
            });
          });
        }
      },
      insertUser(){
        this.getPopup({
          component: 'appui-vcs-project-users-new',
          label: bbn._('Add an user'),
          width: 400
        })
      }
    },
    components: {
      avatar: {
        template: `<bbn-initial :user-name="source.name"/>`,
        props: {
          source: {
            type: Object
          }
        }
      },
      author: {
        template: `
          <div class="bbn-vmiddle">
            <template v-if="!!source.author.name">
              <bbn-initial :user-name="source.author.name"/>
              <div class="bbn-left-xsspace">
                <div v-text="source.author.name"/>
                <div v-text="'@' + source.author.username"/>
              </div>
            </template>
          </div>
        `,
        props: {
          source: {
            type: Object
          }
        }
      }
    }
  }
})();