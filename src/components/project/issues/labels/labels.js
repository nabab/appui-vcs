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
              icon: 'nf nf-fa-square bbn-lg',
              action: this.addLabel,
              label: l
            });
          }
        });
        return menu;
      },
      newLabel(){
        this.getPopup({
          component: this.$options.components.newLabel,
          title: false,
          closable: false,
          width: '20rem',
          source: {
            serverID: this.project.source.server.id,
            projectID: this.project.source.id
          }
        });
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
      },
      newLabel: {
        template: `
          <bbn-form :source="formSource"
                    :data="source"
                    @success="onSuccess"
                    :action="root + 'actions/project/issue/label/create'">
            <div class="bbn-padded bbn-grid-fields">
              <label class="bbn-label">` + bbn._('Name') + `</label>
              <bbn-input v-model="formSource.name"
                         :required="true"/>
              <label class="bbn-label">` + bbn._('Color') + `</label>
              <bbn-colorpicker v-model="formSource.color"
                               :required="true"/>
            </div>
          </bbn-form>
        `,
        props: {
          source: {
            type: Object
          }
        },
        data(){
          return {
            root: appui.plugins['appui-vcs'] + '/',
            formSource: {
              name: '',
              color: ''
            }
          }
        },
        methods: {
          onSuccess(d){
            if (d.success && d.data) {
              this.closest('appui-vcs-project').source.labels.push(d.data);
              this.closest('bbn-floater').opener.addLabel(0, {label: d.data});
            }
            else {
              appui.error();
            }
          }
        }
      }
    }
  }
})();