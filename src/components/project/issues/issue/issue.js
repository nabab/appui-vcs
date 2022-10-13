(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
        showOpenInNewWindowButton: false
      }
    },
    computed: {
      isClosed(){
        return this.source.state === 'closed';
      }
    },
    methods: {
      getMenuSource(){
        let menu = [];
        if (this.isYou(this.source.author.id)) {
          menu.push({
            text: bbn._('Edit'),
            icon: 'nf nf-fa-edit',
            action: this.editIssue
          })
        }
        if (this.isClosed) {
          menu.push({
            text: bbn._('Reopen'),
            icon: 'nf nf-mdi-close_circle',
            action: this.reopenIssue
          });
        }
        else {
          menu.push({
            text: bbn._('Close'),
            icon: 'nf nf-mdi-close_circle',
            action: this.closeIssue
          });
        }
        menu.push({
          text: bbn._('Open in new window'),
          icon: 'nf nf-mdi-open_in_new',
          action: this.openInNewWindow
        });
        if (this.source.collapsed) {
          menu.push({
            text: bbn._('Expand'),
            icon: 'nf nf-mdi-arrow_expand',
            action: () => {
              this.source.collapsed = false;
            }
          });
        }
        else {
          menu.push({
            text: bbn._('Collapse'),
            icon: 'nf nf-mdi-arrow_collapse',
            action: () => {
              this.source.collapsed = true;
            }
          });
        }
        if (!!this.source.idAppuiTask) {
          menu.push({
            text: bbn._('Open in Tasks'),
            icon: 'nf nf-oct-clippy',
            action: () => {
              bbn.fn.link(appui.plugins['appui-task'] + '/page/task/' + this.source.idAppuiTask);
            }
          });
        }
        else {
          menu.push({
            text: bbn._('Import to Task'),
            icon: 'nf nf-oct-clippy',
            action: this.importIssueOnTask
          });
        }
        return menu;
      },
      editIssue(){
        this.getPopup({
          title: false,
          closable: false,
          width: '90%',
          height: '90%',
          component: 'appui-vcs-project-issues-issue-form',
          source: this.source
        });
      },
      closeIssue(){
        if (!this.isClosed) {
          this.confirm(bbn._('Are you sure you want to close this issue?'), () => {
            this.post(this.root + '/actions/project/issue/close', {
              serverID: this.project.source.server.id,
              projectID: this.project.source.id,
              issueID: this.source.id
            }, d => {
              if (d.success && d.data) {
                bbn.fn.iterate(d.data, (v, k) => {
                  this.$set(this.source, k, v);
                });
                appui.success();
              }
              else {
                appui.error();
              }
            });
          });
        }
      },
      reopenIssue(){
        if (this.isClosed) {
          this.confirm(bbn._('Are you sure you want to reopen this issue?'), () => {
            this.post(this.root + '/actions/project/issue/reopen', {
              serverID: this.project.source.server.id,
              projectID: this.project.source.id,
              issueID: this.source.id
            }, d => {
              if (d.success && d.data) {
                bbn.fn.iterate(d.data, (v, k) => {
                  this.$set(this.source, k, v);
                });
                appui.success();
              }
              else {
                appui.error();
              }
            });
          });
        }
      },
      openInNewWindow(){
        this.getPopup({
          title: false,
          closable: false,
          width: '90%',
          height: '90%',
          component: 'appui-vcs-project-issues-comment',
          source: this.source
        });
      },
      openComments(){
        this.getPopup({
          title: false,
          closable: false,
          width: '90%',
          height: '90%',
          component: 'appui-vcs-project-issues-comments',
          source: this.source
        });
      },
      importIssueOnTask(){
        if (!this.source.idAppuiTask) {
          this.confirm(bbn._('Are you sure you want to import this issue on appui-task?'), () => {
            this.post(this.root + 'actions/project/issue/import', {
              serverID: this.project.source.server.id,
              projectID: this.project.source.id,
              issueID: this.source.id
            }, d => {
              if (d.success && d.data) {
                this.source.idAppuiTask = d.data;
                if (!!appui.plugins['appui-task']) {
                  bbn.fn.link(appui.plugins['appui-task'] + '/page/task/' + this.source.idAppuiTask);
                }
                appui.success();
              }
              else {
                appui.error();
              }
            })
          });
        }
      },
      getAssignmentList(){
        if (!this.isClosed) {
          let users = bbn.fn.map(bbn.fn.extend(true, [], bbn.fn.order(this.project.source.members, 'name', 'asc')), u => {
            return {
              idIssue: this.source.id,
              id: u.id,
              name: u.name,
              username: u.username,
              action: () => {
                this.assignUser(u.id);
              }
            }
          });
          users.unshift({
            idIssue: this.source.id,
            id: 0,
            name: bbn._('Remove assignment'),
            action: () => {
              this.assignUser(0);
            }
          })
          return bbn.fn.numProperties(this.source.assigned) ? bbn.fn.filter(users, u => u.id !== this.source.assigned.id) : users;
        }
        return [];
      },
      assignUser(idUser){
        if (!this.isClosed) {
          this.post(this.root + 'actions/project/issue/assign', {
            serverID: this.project.source.server.id,
            projectID: this.project.source.id,
            issueID: this.source.id,
            userID: idUser
          }, d => {
            if (d.success && d.data) {
              bbn.fn.iterate(d.data, (v, k) => {
                this.$set(this.source, k, v);
              });
              appui.success();
            }
            else {
              appui.error();
            }
          });
        }
      }
    },
    mounted(){
      this.$nextTick(() => {
        if (this.getRef('description').clientHeight >= 600) {
          this.showOpenInNewWindowButton = true;
        }
      });
    }
  }
})();