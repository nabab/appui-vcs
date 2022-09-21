(() => {
  return {
    data(){
      return {
        issues: []
      }
    },
    computed: {
      opened(){
        return bbn.fn.filter(this.issues, i => i.state === 'opened');
      },
      closed(){
        return bbn.fn.filter(this.issues, i => i.state === 'closed');
      },
      sections(){
        let sec = [{
          title: bbn._('Opened'),
          items: this.opened
        }];
        bbn.fn.each(this.source.labels, l => sec.push({
          title: l.name,
          items: bbn.fn.filter(this.issues, i => i.labels.includes(l.name))
        }));
        sec.push({
          title: bbn._('Closed'),
          items: this.closed
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
        });
      }
    },
    created(){
      this.refreshList();
    }
  }
})();