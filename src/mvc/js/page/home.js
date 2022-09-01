(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-vcs'] + '/',
        selectedServers: []
      }
    },
    computed: {
      selectedServer(){
        return this.selectedServers.length ? this.selectedServers[0] : false;
      }
    },
    methods: {
      createServer(){
        this.getPopup({
          title: bbn._('New server'),
          component: 'appui-vcs-form-server',
          width: 500,
          source: {
            name: '',
            url: '',
            type: 'git',
            adminToken: '',
            userToken: ''
          }
        })
      },
      createProject(){

      },
      refreshServersList(){
        this.getRef('serversList').updateData();
      }
    },
    created(){
      appui.register('appui-vcs-home', this);
    },
    components: {
      server: {
        template: `
          <div class="bbn-flex-width">
            <div class="bbn-vmiddle bbn-spadded bbn-white"
                 style="background-color: #EF502F">
              <i v-if="source.type === 'git'"
                 class="nf nf-fa-git bbn-xxxl"/>
            </div>
            <div class="bbn-flex-fill bbn-grid-fields bbn-spadded"
                 style="gap: 0 1rem">
              <label class="bbn-label bbn-b">` + bbn._('Name') + `</label>
              <div v-text="source.name"/>
              <label class="bbn-label bbn-b">` + bbn._('URL') + `</label>
              <div v-text="source.url"/>
            </div>
            <div>
              <bbn-button icon="nf nf-oct-settings"
                          class="bbn-secondary bbn-no-radius bbn-h-100 bbn-xl"
                          @click="edit"/>
            </div>
          </div>
        `,
        props: {
          source: {
            type: Object
          },
          index: {
            type: Number
          }
        },
        methods: {
          edit(){
            this.getPopup({
              title: bbn._('Edit server'),
              component: 'appui-vcs-form-server',
              width: 500,
              source: this.source
            });
          }
        }
      }
    }
  }
})();