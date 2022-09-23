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
          let items = bbn.fn.filter(this.filteredIssues, i => i.labels.includes(l.name));
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
      }
    },
    methods: {
      numProperties: bbn.fn.numProperties,
      refreshList(){
        this.post(this.mainPage.root + 'data/project/issues', {
          serverID: this.source.idServer,
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
      }
    },
    created(){
      this.refreshList();
    }
  }
})();