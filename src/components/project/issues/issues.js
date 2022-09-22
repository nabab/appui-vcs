(() => {
  return {
    data(){
      return {
        ready: false,
        issues: [],
        currentFilter: 'all'
      }
    },
    computed: {
      yourUserID(){
        let info = bbn.fn.getField(this.project.source.appui.users, 'info', 'id', appui.app.user.id);
        return !!info ? info.id : null;
      },
      filters(){
        if (this.yourUserID) {
          switch (this.currentFilter) {
            case 'mine':
              return {'author.id': this.yourUserID};
            case 'assigned':
              return {'assigned.id': this.yourUserID};
            }
          }
        return {};
      },
      opened(){
        return bbn.fn.filter(this.issues, bbn.fn.extend({state: 'opened'}, this.filters));
      },
      closed(){
        return bbn.fn.filter(this.issues, bbn.fn.extend({state: 'closed'}, this.filters));
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
          let items = bbn.fn.filter(this.issues, i => i.labels.includes(l.name));
          if (bbn.fn.numProperties(this.filters)) {
            items = bbn.fn.filter(items, this.filters);
          }
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
      }
    },
    created(){
      this.refreshList();
    }
  }
})();