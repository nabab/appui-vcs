(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    methods: {
      addIssue(){
        this.getPopup({
          title: false,
          closable: false,
          width: '90%',
          height: '90%',
          component: 'appui-vcs-project-issues-issue-form',
          source: {
            title: '',
            description: '',
            labels: !!this.source.data.label ? [this.source.data.label.name] : [],
            private: false,
            assigned: {}
          }
        });
      },
      collapseAll(){
        if (this.source.data.items && this.source.data.items.length) {
          bbn.fn.each(this.source.data.items, item => item.collapsed = true);
        }
      },
      expandAll(){
        if (this.source.data.items && this.source.data.items.length) {
          bbn.fn.each(this.source.data.items, item => {
            item.collapsed = false
          });
        }
      }
    }
  }
})();