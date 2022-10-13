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
            backgroundColor: l.backgroundColor || '',
            fontColor: l.fontColor || '',
            label: l,
            canAdd: true
          });
        });
        sec.push({
          title: bbn._('Closed'),
          items: this.closed,
          backgroundColor: null,
          fontColor: null,
          label: false,
          canAdd: false
        });
        return sec;
      }
    },
    methods: {
      normalizeIssue(issue){
        issue.descriptionHtml = issue.description.replace(
          /\!\[[a-zA-Z0-9\/\.\-\_]+\]\({1}([a-zA-Z0-9\/\.\-\_]+\.{1}(jpg|png|jpeg){1})\){1}/gm,
          '<img class="appui-vcs-project-issues-img" src="' + this.source.server.host + '/' + this.source.fullpath + '/$1">'
        );
        issue.collapsed = false;
        return issue;
      },
      refreshList(){
        this.post(this.root + 'data/project/issues/list', {
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
      clearSearch(){
        if (this.currentSearch.length) {
          this.currentSearch = '';
        }
      }
    },
    beforeMount(){
      this.refreshList();
    },
    watch: {
      filteredIssues(){
        this.$nextTick(() => {
          let s = this.getRef('sections');
          if (s) {
            s.updateData();
          }
        })
      }
    }
  }
})();