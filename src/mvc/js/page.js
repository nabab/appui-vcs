(() => {
  return {
    name: 'appui-vcs',
    data(){
      return {
        root: appui.plugins['appui-vcs'] + '/'
      }
    },
    methods: {
      isMobile: bbn.fn.isMobile,
      formatDate(date){
        return dayjs(date).format('DD/MM/YY HH:mm');
      }
    }
  }
})();