(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
        formSource: {
          title: '',
          description: '',
          labels: !!this.source.label ? [this.source.label.name] : [],
          private: false,
          assigned: {}
        }
      }
    },
    computed: {
      formData(){
        return {
          serverID: this.project.source.server.id,
          projectID: this.project.source.id
        };
      }
    },
    methods: {
      close(){
        this.currentPopup.close(this.currentPopup.items.length - 1, true);
      },
      onSuccess(d){
        if (d.success && d.data) {
          let opener = this.closest('bbn-floater').opener;
          if (!this.source.id) {
            opener.issues.unshift(opener.normalizeIssue(d.data));
          }
          else {
            bbn.fn.iterate(opener.normalizeIssue(d.data), (v, k) => {
              this.source[k] = v;
            });
          }
          appui.success();
          this.close();
        }
        else {
          appui.error();
        }
      },
      getAssignmentList(idx, item){
        let users = bbn.fn.map(bbn.fn.extend(true, [], bbn.fn.order(this.project.source.members, 'name', 'asc')), u => {
          return {
            idIssue: item.id,
            id: u.id,
            name: u.name,
            username: u.username,
            action: () => {
              let usr = bbn.fn.getRow(this.project.source.members, 'id', u.id);
              if (usr) {
                this.$set(this.source, 'assigned', usr);
              }
            }
          }
        });
        users.unshift({
          idIssue: item.id,
          id: 0,
          name: bbn._('Remove assignment'),
          action: () => {
            this.$set(this.source, 'assigned', {});
          }
        })
        return bbn.fn.numProperties(item.assigned) ? bbn.fn.filter(users, u => u.id !== item.assigned.id) : users;
      }
    }
  }
})();