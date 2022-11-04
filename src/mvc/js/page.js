(() => {
  return {
    name: 'appui-vcs',
    data(){
      let engines = [];
      bbn.fn.iterate(this.source.engines, (es, type) => {
        bbn.fn.iterate(es, (o, e) => {
          engines.push({
            text: o.name,
            value: e,
            type: type
          });
        });
      });
      return {
        root: appui.plugins['appui-vcs'] + '/',
        enginesTypes: bbn.fn.map(Object.keys(this.source.engines), e => {
          return {
            text: bbn.fn.correctCase(e),
            value: e
          };
        }),
        engines: engines
      }
    },
    methods: {
      isMobile: bbn.fn.isMobile,
      formatDate(date){
        return dayjs(date).format('DD/MM/YY HH:mm');
      }
    },
    created(){
      appui.register('appui-vcs', this);
    }
  }
})();