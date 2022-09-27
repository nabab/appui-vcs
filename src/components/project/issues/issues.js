(() => {
  return {
    data(){
      return {
        ready: false,
        issues: [],
        currentFilter: 'all',
        currentSearch: ''
      }
    },
    computed: {
      yourUserID(){
        let info = bbn.fn.getField(this.project.source.appui.users, 'info', 'id', appui.app.user.id);
        return !!info ? info.id : null;
      },
      filters(){
        let filters = {
          logic: 'AND',
          conditions: []
        };
        if (this.yourUserID) {
          switch (this.currentFilter) {
            case 'mine':
              filters.conditions.push({
                field: 'author.id',
                operator: '=',
                value: this.yourUserID
              });
              break;
            case 'assigned':
              filters.conditions.push({
                field: 'assigned.id',
                operator: '=',
                value: this.yourUserID
              });
              break;
          }
        }
        if (this.currentSearch.length) {
          filters.conditions.push({
            logic: 'OR',
            conditions: [{
              field: 'title',
              operator: 'contains',
              value: this.currentSearch
            }, {
              field: 'description',
              operator: 'contains',
              value: this.currentSearch
            }, {
              field: 'author.name',
              operator: 'contains',
              value: this.currentSearch
            }, {
              field: 'assigned.name',
              operator: 'contains',
              value: this.currentSearch
            }]
          });
        }
        return filters;
      },
      filteredIssues(){
        return bbn.fn.filter(this.issues, this.filters);
      },
      opened(){
        return bbn.fn.filter(this.filteredIssues, {state: 'opened'});
      },
      closed(){
        return bbn.fn.filter(this.filteredIssues, {state: 'closed'});
      },
      sections(){
        let sec = [{
          title: bbn._('Opened'),
          items: this.opened,
          collapsed: false,
          backgroundColor: null,
          fontColor: null
        }];
        bbn.fn.each(this.source.labels, l => {
          let items = bbn.fn.filter(this.opened, i => i.labels.includes(l.name));
          sec.push({
            title: l.name,
            items: items,
            collapsed: !items.length,
            backgroundColor: l.backgroundColor || '',
            fontColor: l.fontColor || ''
          });
        });
        sec.push({
          title: bbn._('Closed'),
          items: this.closed,
          collapsed: !this.closed.length,
          backgroundColor: null,
          fontColor: null
        });
        return sec;
      },
      assignList(){

      }
    },
    methods: {
      numProperties: bbn.fn.numProperties,
      refreshList(){
        this.post(this.mainPage.root + 'data/project/issues', {
          serverID: this.source.server.id,
          projectID: this.source.id
        }, d => {
          if (d.success && bbn.fn.isArray(d.data)) {
            this.issues.splice(0, this.issues.length, ...d.data);
          }
          this.ready = true;
        });
      },
      collapse(section){
        section.collapsed = true;
        this.$forceUpdate();
      },
      expand(section){
        section.collapsed = false;
        this.$forceUpdate();
      },
      expandAll(){
        bbn.fn.each(this.sections, s => {
          s.collapsed = false;
        });
        this.$forceUpdate();
      },
      collapseAll(){
        bbn.fn.each(this.sections, s => {
          s.collapsed = true;
        });
        this.$forceUpdate();
      },
      isYou(idUser){
        return this.yourUserID === idUser;
      },
      getLabelBackground(label){
        return bbn.fn.getField(this.source.labels, 'backgroundColor', 'name', label);
      },
      getLabelColor(label){
        return bbn.fn.getField(this.source.labels, 'fontColor', 'name', label);
      },
      getMenuSource(item){
        let menu = [];
        if (item.state === 'opened') {
          menu.push({
            text: bbn._('Close'),
            icon: 'nf nf-mdi-close_circle',
            action: () => this.closeIssue(item)
          });
        }
        if (item.state === 'closed') {
          menu.push({
            text: bbn._('Reopen'),
            icon: 'nf nf-mdi-close_circle',
            action: () => this.reopenIssue(item)
          });
        }
        return menu;
      },
      closeIssue(item){
        if (item.state === 'opened') {
          this.confirm(bbn._('Are you sure you want to close this issue?'), () => {
            this.post(this.mainPage.root + '/actions/project/issue/close', {
              serverID: this.project.source.server.id,
              projectID: this.project.source.id,
              issueID: item.id
            }, d => {
              if (d.success && d.data) {
                bbn.fn.iterate(d.data, (v, k) => {
                  this.$set(item, k, v);
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
      reopenIssue(item){
        if (item.state === 'closed') {
          this.confirm(bbn._('Are you sure you want to reopen this issue?'), () => {
            this.post(this.mainPage.root + '/actions/project/issue/reopen', {
              serverID: this.project.source.server.id,
              projectID: this.project.source.id,
              issueID: item.id
            }, d => {
              if (d.success && d.data) {
                bbn.fn.iterate(d.data, (v, k) => {
                  this.$set(item, k, v);
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
      isClosed(item){
        return item.state === 'closed';
      },
      getAssignmentList(item){
        if (!this.isClosed(item)) {
          let users = bbn.fn.map(bbn.fn.extend(true, [], bbn.fn.order(this.source.members, 'name', 'asc')), u => {
            return {
              idIssue: item.id,
              id: u.id,
              name: u.name,
              username: u.username,
              action: () => {
                this.assignUser(item.id, u.id);
              }
            }
          });
          users.unshift({
            idIssue: item.id,
            id: 0,
            name: bbn._('Remove assignment'),
            action: () => {
              this.assignUser(item.id, 0);
            }
          })
          return this.numProperties(item.assigned) ? bbn.fn.filter(users, u => u.id !== item.assigned.id) : users;
        }
        return [];
      },
      assignUser(idIssue, idUser){
        let issue = bbn.fn.getRow(this.issues, 'id', idIssue);
        if (issue && !this.isClosed(issue)) {
          this.post(this.mainPage.root + 'actions/project/issue/assign', {
            serverID: this.project.source.server.id,
            projectID: this.project.source.id,
            issueID: idIssue,
            userID: idUser
          }, d => {
            if (d.success && d.data) {
              bbn.fn.iterate(d.data, (v, k) => {
                this.$set(issue, k, v);
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
    created(){
      this.refreshList();
    },
    components: {
      assignUser: {
        template: `
          <div class="bbn-vmiddle bbn-spadded">
            <template v-if="source.id">
              <bbn-initial :user-name="source.name"
                           width="1.2rem"
                           height="1.2rem"
                           font-size="0.7rem"/>
              <span class="bbn-left-xsspace"
                    v-text="source.name"/>
              <span class="bbn-i bbn-left-xsspace">(<span v-text="source.username"/>)</span>
            </template>
            <div v-else>
              <i class="nf nf-mdi-account_remove bbn-red bbn-lg"/>
              <span v-text="source.name"
                    class="bbn-left-xsspace"/>
            </div>
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