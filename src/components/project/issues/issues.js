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
          fontColor: null,
          label: false,
          canAdd: true
        }];
        bbn.fn.each(this.source.labels, l => {
          let items = bbn.fn.filter(this.opened, i => i.labels.includes(l.name));
          sec.push({
            title: l.name,
            items: items,
            collapsed: !items.length,
            backgroundColor: l.backgroundColor || '',
            fontColor: l.fontColor || '',
            label: l,
            canAdd: true
          });
        });
        sec.push({
          title: bbn._('Closed'),
          items: this.closed,
          collapsed: !this.closed.length,
          backgroundColor: null,
          fontColor: null,
          label: false,
          canAdd: false
        });
        return sec;
      }
    },
    methods: {
      numProperties: bbn.fn.numProperties,
      normalizeIssue(issue){
        issue.descriptionHtml = issue.description.replace(
          /\!\[[a-zA-Z0-9\/\.\-\_]+\]\({1}([a-zA-Z0-9\/\.\-\_]+\.{1}(jpg|png|jpeg){1})\){1}/gm,
          '<img class="appui-vcs-project-issues-img" src="' + this.source.server.host + '/' + this.source.fullpath + '/$1">'
        );
        return issue;
      },
      refreshList(){
        this.post(this.mainPage.root + 'data/project/issues/list', {
          serverID: this.source.server.id,
          projectID: this.source.id
        }, d => {
          if (d.success && bbn.fn.isArray(d.data)) {
            this.issues.splice(
              0,
              this.issues.length,
              ...bbn.fn.map(d.data, this.normalizeIssue)
            );
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
      getMenuSource(item){
        let menu = [];
        if (this.isYou(item.author.id)) {
          menu.push({
            text: bbn._('Edit'),
            icon: 'nf nf-fa-edit',
            action: () => this.editIssue(item)
          })
        }
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
        menu.push({
          text: bbn._('Open in new window'),
          icon: 'nf nf-fa-window_maximize',
          action: () => this.openComment(item)
        });
        return menu;
      },
      addIssue(section){
        this.getPopup({
          title: false,
          closable: false,
          width: '90%',
          height: '90%',
          component: 'appui-vcs-project-issues-issue',
          source: {
            title: '',
            description: '',
            labels: !!section.label ? [section.label.name] : [],
            private: false,
            assigned: {}
          }
        });
      },
      editIssue(issue){
        this.getPopup({
          title: false,
          closable: false,
          width: '90%',
          height: '90%',
          component: 'appui-vcs-project-issues-issue',
          source: issue
        });
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
      getAssignmentList(idx, item){
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
      },
      openComment(issue){
        this.getPopup({
          title: false,
          closable: false,
          width: '90%',
          height: '90%',
          component: 'appui-vcs-project-issues-comment',
          source: issue
        });
      },
      openComments(issue){
        this.getPopup({
          title: false,
          closable: false,
          width: '90%',
          height: '90%',
          component: 'appui-vcs-project-issues-comments',
          source: issue
        });
      }
    },
    created(){
      this.refreshList();
    },
    components: {
      issueDescription: {
        name: 'issue-description',
        template: `
        <div class="bbn-vsmargin bbn-w-100">
          <pre v-html="source.descriptionHtml"
               class="appui-vcs-project-issues-item-text"/>
          <div class="bbn-c bbn-vmargin"
               v-if="showZoom">
            <bbn-button class="bbn-no-border bbn-upper bbn-xs"
                        text="` + bbn._('Show more content') + `"
                        @click="$emit('zoom', source)"/>
          </div>
        </div>
        `,
        props: {
          source: {
            type: Object
          }
        },
        data(){
          return {
            showZoom: false
          }
        },
        mounted(){
          this.$nextTick(() => {
            if (this.$el.clientHeight >= 600) {
              this.showZoom = true;
            }
          });
        }
      }
    }
  }
})();