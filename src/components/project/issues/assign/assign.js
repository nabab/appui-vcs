(() => {
  return {
    props: {
      source: {
        type: Object
      },
      menu: {
        type: Function
      },
      disabled: {
        type: Boolean,
        default: false
      },
      icons: {
        type:Boolean,
        default: true
      }
    },
    methods: {
      numProperties: bbn.fn.numProperties,
      isYou(idUser){
        return this.yourUserID === idUser;
      }
    },
    components: {
      assignUser: {
        template: `
          <div class="bbn-vmiddle bbn-spadding">
            <template v-if="source.id">
              <bbn-initial :user-name="source.name"
                           width="1.2rem"
                           height="1.2rem"
                           font-size="0.7rem"/>
              <span class="bbn-left-xsspace"
                    v-text="source.name"/>
              <span class="bbn-i bbn-left-xsspace">(<span v-text="source.username"/>)</span>
            </template>
            <div v-else>
              <i class="nf nf-mdi-account_remove bbn-red bbn-lg"/>
              <span v-text="source.name"
                    class="bbn-left-xsspace"/>
            </div>
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