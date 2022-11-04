(() => {
  return {
    data(){
      return {
        root: appui.plugins['appui-vcs'] + '/',
        selectedServers: [],
        projectsListReady: false,
        projectsListLoading: true
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
          component: 'appui-vcs-server-new',
          width: 500,
          source: {
            name: '',
            host: '',
            type: 'git',
            engine: '',
            adminAccessToken: '',
            userAccessToken: ''
          }
        })
      },
      createProject(){

      },
      refreshServersList(){
        this.getRef('serversList').updateData();
      },
      setProjectsListWatch(){
        this.projectsListReady = true;
        this.getRef('projectsList').$watch('isLoading', newVal => {
          this.projectsListLoading = newVal;
        });
      },
      onServerSelect(data, idx, index, ev){
        ev.preventDefault();
      },
      onProjectSelect(data, idx, index, ev){
        ev.preventDefault();
      }
    },
    created(){
      appui.register('appui-vcs-home', this);
    },
    components: {
      server: {
        template: `
          <div class="bbn-flex-width">
            <div :class="['bbn-vmiddle', 'bbn-spadded', 'bbn-white', {
                   'bbn-bordered-bottom': !!comp.getRef('serversList').currentData[index + 1]
                 }]"
                 style="background-color: #EF502F"
                 @click="select">
              <i :class="['bbn-xxxl', {
                   'nf nf-fa-git': source.type === 'git',
                   'nf nf-dev-sublime': source.type === 'svn'
                 }]"/>
            </div>
            <div class="bbn-flex-fill bbn-grid-fields bbn-spadded"
                 style="gap: 0 1rem"
                 @click="select">
              <label class="bbn-label bbn-b">` + bbn._('Name') + `</label>
              <div v-text="source.name"/>
              <label class="bbn-label bbn-b">` + bbn._('Host') + `</label>
              <div v-text="source.host"/>
            </div>
            <div :class="{'bbn-bordered-bottom': !!comp.getRef('serversList').currentData[index + 1]}">
              <bbn-button icon="nf nf-oct-settings"
                          class="bbn-secondary bbn-no-radius bbn-h-100 bbn-xl"
                          @click.stop="edit"
                          :style="{'border-top-right-radius': !index ? '0.4rem !important' : 0}"/>
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
        data(){
          return {
            comp: appui.getRegistered('appui-vcs-home')
          }
        },
        methods: {
          select(){
            if (this.comp.selectedServers[0] !== this.source.id) {
              this.comp.selectedServers.splice(0);
              this.comp.$nextTick(() => {
                this.comp.selectedServers.push(this.source.id);
              });
            }
          },
          edit(){
            this.getPopup({
              title: bbn._('Edit server'),
              component: 'appui-vcs-server-new',
              width: 500,
              source: this.source
            });
          }
        }
      },
      project: {
        template: `
          <div class="bbn-flex-width"
               @click="openProject">
            <div :class="['bbn-vmiddle', 'bbn-spadded', 'bbn-white', {
                   'bbn-bg-red': !!source.private,
                   'bbn-bg-green': !source.private,
                   'bbn-bg-blue': !!source.archived,
                   'bbn-bordered-bottom': !!comp.getRef('projectsList').currentData[index + 1]
                 }]">
              <i :class="['bbn-xxl', {
                   'nf nf-mdi-lock': !!source.private,
                   'nf nf-mdi-lock_open': !source.private,
                   'nf nf-fa-archive': !!source.archived
                 }]"/>
            </div>
            <div class="bbn-flex-fill bbn-grid-fields bbn-spadded"
                 style="gap: 0 1rem">
              <label class="bbn-label bbn-b">` + bbn._('Name') + `</label>
              <div v-text="source.name"/>
              <label class="bbn-label bbn-b">` + bbn._('Path') + `</label>
              <div v-text="source.fullpath"/>
              <label class="bbn-label bbn-b">` + bbn._('Description') + `</label>
              <div v-text="source.description"/>
              <label class="bbn-label bbn-b">` + bbn._('URL') + `</label>
              <div v-text="source.url"/>
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
        data(){
          return {
            comp: appui.getRegistered('appui-vcs-home')
          }
        },
        methods: {
          openProject(){
            let url = this.comp.root +
              'page/project/' +
              this.comp.selectedServer + '/' +
              this.source.id;
            bbn.fn.link(url);
          }
        }
      }
    }
  }
})();