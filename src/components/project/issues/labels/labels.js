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
          label: false,
          closable: false,
          //width: '20rem',
          //height: '25rem',
          source: {
            serverID: this.project.source.server.id,
            projectID: this.project.source.id
          }
        });
      },
      addLabel(idx, l){
        if (this.editMode) {
          this.post(this.root + 'actions/project/issue/label/add', {
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
          this.post(this.root + 'actions/project/issue/label/remove', {
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
          <div class="bbn-spadding bbn-vmiddle">
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
          <div class="bbn-background">
            <div :class="['bbn-spadding', 'bbn-background', 'bbn-radius', 'bbn-vmiddle', 'bbn-nowrap', {
                    'bbn-flex-width': !main.mainPage.isMobile(),
                    'bbn-flex-height': !!main.mainPage.isMobile()
                  }]">
              <div :class="[
                      'bbn-upper',
                      'bbn-b',
                      'bbn-lg',
                      'bbn-secondary-text-alt',
                      'bbn-flex-fill',
                      'bbn-alt-background',
                      'bbn-spadding',
                      'bbn-radius',
                      {
                        'bbn-left-sspace bbn-right-space': !main.mainPage.isMobile(),
                        'bbn-top-space bbn-bottom-space': !!main.mainPage.isMobile(),
                      }
                    ]"
                    v-text="'` + bbn._('New label') + `'"/>
              <div>
                <bbn-button class="bbn-no-border"
                            icon="nf nf-fa-close bbn-lg"
                            @click="close"/>
              </div>
            </div>
            <div class="bbn-w-100 bbn-alt-background bbn-radius bbn-top-sspace">
              <bbn-form :source="formSource"
                        :data="source"
                        @success="onSuccess"
                        :action="root + 'actions/project/issue/label/create'"
                        :scrollable="false"
                        :windowed="false"
                        :buttons="[{
                          text: _('Cancel'),
                          icon: 'nf nf-fa-times_circle',
                          action: close
                        }, 'submit']">
                <div class="bbn-padding bbn-grid-fields">
                  <label class="bbn-label">` + bbn._('Name') + `</label>
                  <bbn-input v-model="formSource.name"
                            :required="true"/>
                  <label class="bbn-label">` + bbn._('Color') + `</label>
                  <bbn-colorpicker v-model="formSource.color"
                                  :required="true"/>
                </div>
              </bbn-form>
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
            root: appui.plugins['appui-vcs'] + '/',
            main: this.closest('bbn-floater').opener,
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
              this.main.addLabel(0, {label: d.data});
            }
            else {
              appui.error();
            }
          },
          close(){
            this.main.currentPopup.close(this.main.currentPopup.items.length - 1, true);
          },
        }
      }
    }
  }
})();