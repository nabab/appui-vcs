(() => {
  return {
    computed: {
      tableSource(){
        return bbn.fn.order(this.source.branches, 'name', 'asc');
      }
    },
    methods: {
      renderDefault(row){
        return !!row.default ? '<i class="nf nf-fa-star bbn-primary-text-alt"/>' : '';
      },
      renderCreated(row){
        return dayjs(row.created).format('DD/MM/YYYY HH:mm');
      },
      insertBranch(){
        this.getPopup({
          component: 'appui-vcs-project-branches-new',
          title: bbn._('Create a new branch'),
          width: 400
        })
      },
      removeBranch(row){
        if (!!this.project.source.idServer
          && !!this.project.source.id
          && !!row.name
          && row.name.length
        ) {
          this.confirm(bbn._('Are you sure you want to delete the branch "%s"?', row.name), () => {
            this.post(this.mainPage.root + 'actions/project/branch/delete', {
              serverID: this.project.source.idServer,
              projectID: this.project.source.id,
              branch: row.name
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
      }
    },
    components: {
      author: {
        template: `
          <div class="bbn-vmiddle">
            <bbn-initial :user-name="source.author.name"
                         width="1.2rem"
                         height="1.2rem"
                         font-size="0.7rem"/>
            <span class="bbn-left-xsspace"
                  v-text="source.author.name"/>
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