(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
        isLoading: false,
        comments: [],
        commentForm: false,
        formSource: {
          content: ''
        }
      }
    },
    methods: {
      refreshList(){
        this.isLoading = true;
        this.post(this.mainPage.root + 'data/project/issues/comments', {
          serverID: this.project.source.server.id,
          projectID: this.project.source.id,
          issueID: this.source.id
        }, d => {
          if (d.success && d.data) {
            this.comments.splice(0, this.comments.length, ...bbn.fn.filter(bbn.fn.map(d.data, comment => {
              comment.contentHtml = comment.content.replace(
                /\!\[[a-zA-Z0-9\/\.\-\_]+\]\({1}([a-zA-Z0-9\/\.\-\_]+\.{1}(jpg|png|jpeg){1})\){1}/gm,
                '<img class="appui-vcs-project-issues-comments-img" src="' +
                  this.project.source.server.host + '/' + this.project.source.fullpath + '/$1">'
              );
              return comment;
            }), c => !c.auto));
          }
          this.isLoading = false;
        });
      },
      getMenuSource(idx, item){
        return []
      },
      isYou(idUser){
        return this.yourUserID === idUser;
      },
      newComment(){
        this.commentForm = true;
      },
      scrollEnd(){
        const scroll = this.getRef('scroll');
        this.$nextTick(() => {
          scroll.onResize().then(() => {
            setTimeout(() => {
              scroll.scrollEndY();
            }, 1000);
          });
        })
      }
    },
    created(){
      this.refreshList();
    }
  }
})();