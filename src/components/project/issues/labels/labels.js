(() => {
  return {
    props: {
      source: {
        type: Object
      },
      editMode: {
        type: Boolean,
        default: true
      }
    },
    methods: {
      getLabelBackground(label){
        return bbn.fn.getField(this.project.source.labels, 'backgroundColor', 'name', label);
      },
      getLabelColor(label){
        return bbn.fn.getField(this.project.source.labels, 'fontColor', 'name', label);
      },
      getMenuSource(){
        let menu = [{
          icon: 'nf nf-fa-plus',
          action: this.newLabel,
          label: {
            name: bbn._('Add a new label'),
            color: '',
            backgroundColor: ''
          },
        }];
        bbn.fn.each(this.project.source.labels, l => {
          if (!this.source.labels.includes(l.name)) {
            menu.push({
              icon: 'nf nf-fa-square',
              action: this.addLabel,
              label: l
            });
          }
        });
        return menu;
      },
      newLabel(){

      },
      addLabel(idx, l){
        if (this.editMode) {
          this.post(this.mainPage.root + 'actions/project/issue/label/add', {
            serverID: this.project.source.server.id,
            projectID: this.project.source.id,
            issueID: this.source.id,
            label: l.label.name
          }, d => {
            if (d.success) {
              this.source.labels.push(l.label.name);
              appui.success();
            }
            else {
              appui.error();
            }
          });
        }
        else {
          this.source.labels.push(l.label.name);
        }
      },
      removeLabel(label){
        if (this.editMode) {
          this.post(this.mainPage.root + 'actions/project/issue/label/remove', {
            serverID: this.project.source.server.id,
            projectID: this.project.source.id,
            issueID: this.source.id,
            label: label
          }, d => {
            if (d.success) {
              let idx = this.source.labels.indexOf(label);
              if (idx > -1) {
                this.source.labels.splice(idx, 1);
              }
              appui.success();
            }
            else {
              appui.error();
            }
          });
        }
        else {
          let idx = this.source.labels.indexOf(label);
          if (idx > -1) {
            this.source.labels.splice(idx, 1);
          }
        }
      }
    },
    components: {
      label: {
        template: `
          <div class="bbn-spadded bbn-vmiddle">
            <i :class="source.icon"
               :style="{color: source.label.backgroundColor}"/>
            <span class="bbn-left-sspace"
                  v-text="source.label.name"/>
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