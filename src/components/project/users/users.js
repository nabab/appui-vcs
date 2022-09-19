(() => {
  return {
    computed: {
      tableSource(){
        return bbn.fn.order(this.source.users, 'name', 'asc');
      }
    },
    methods: {
      renderName(row){
        return `<div><div>${row.name}</div><div class="bbn-i">@${row.username}</div></div>`;
      },
      renderDate(row, col){
        return dayjs(row[col.field]).format('DD/MM/YYYY HH:mm');
      }
    },
    components: {
      avatar: {
        template: `<bbn-initial :user-name="source.name"/>`,
        props: {
          source: {
            type: Object
          }
        }
      },
      author: {
        template: `
          <div class="bbn-vmiddle">
            <template v-if="!!source.author.name">
              <bbn-initial :user-name="source.author.name"/>
              <div class="bbn-left-xsspace">
                <div v-text="source.author.name"/>
                <div v-text="'@' + source.author.username"/>
              </div>
            </template>
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