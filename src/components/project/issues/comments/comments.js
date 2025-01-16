(() => {
  return {
    props: {
      source: {
        type: Object
      },
      fullpage: {
        type: Boolean,
        default: true
      }
    },
    data(){
      return {
        isLoading: false,
        comments: [],
        commentForm: false,
        formSource: {
          content: '',
          private: false
        },
        currentEdit: false
      }
    },
    computed: {
      formData(){
        let d = {
          serverID: this.project.source.server.id,
          projectID: this.project.source.id,
          issueID: this.source.id
        };
        if (this.currentEdit) {
          d.commentID = this.currentEdit;
        }
        return d;
      }
    },
    methods: {
      normalizeComment(comment){
        comment.contentHtml = comment.content.replace(
          /\!\[[a-zA-Z0-9\/\.\-\_]+\]\({1}([a-zA-Z0-9\/\.\-\_]+\.{1}(jpg|png|jpeg){1})\){1}/gm,
          '<img class="appui-vcs-project-issues-comments-img" src="' +
            this.project.source.server.host + '/' + this.project.source.fullpath + '/$1">'
        );
        return comment;
      },
      refreshList(){
        this.isLoading = true;
        this.post(this.root + 'data/project/issues/comments', {
          serverID: this.project.source.server.id,
          projectID: this.project.source.id,
          issueID: this.source.id
        }, d => {
          if (d.success && d.data) {
            this.comments.splice(
              0,
              this.comments.length,
              ...bbn.fn.filter(
                bbn.fn.map(d.data, this.normalizeComment),
                c => !c.auto
              )
            );
          }
          this.isLoading = false;
        });
      },
      getMenuSource(idx, item){
        let menu = [];
        if (this.isYou(item.author.id)) {
          menu.push({
            text: bbn._('Edit'),
            icon: 'nf nf-fa-edit',
            action: () => this.editComment(item)
          }, {
            text: bbn._('Delete'),
            icon: 'nf nf-fa-trash',
            action: () => this.deleteComment(item)
          })
        }
        return menu;
      },
      isYou(idUser){
        return this.yourUserID === idUser;
      },
      newComment(){
        this.formSource.content = '';
        this.currentEdit = false;
        this.commentForm = true;
      },
      editComment(comment){
        this.commentForm = false;
        this.currentEdit = comment.id;
      },
      deleteComment(comment){
        this.confirm(bbn._('Are you sure you want to delete this comment?'), () => {
          this.post(this.root + 'actions/project/issue/comment/delete', {
            serverID: this.project.source.server.id,
            projectID: this.project.source.id,
            issueID: this.source.id,
            commentID: comment.id
          }, d => {
            if (d.success) {
              let idx = bbn.fn.search(this.comments, 'id', comment.id);
              if (idx > -1) {
                this.comments.splice(idx, 1);
              }
              appui.success();
            }
            else {
              appui.error();
            }
          });
        })
      },
      scrollEnd(){
        const scroll = this.fullpage ? this.getRef('scroll') : this.closest('bbn-scroll');
        if (scroll){
          this.$nextTick(() => {
            scroll.onResize().then(() => {
              setTimeout(() => {
                scroll.scrollEndY();
              }, 1000);
            });
          });
        }
      },
      onSuccess(d){
        if (d.success && d.data) {
          this.commentForm = false;
          let idx = bbn.fn.search(this.comments, 'id', d.data.id);
          if (idx > -1) {
            this.comments.splice(idx, 1, this.normalizeComment(d.data));
          }
          else {
            this.comments.push(this.normalizeComment(d.data));
          }
          this.source.notes = this.comments.length;
          this.currentEdit = false;
          appui.success();
        }
        else {
          appui.error();
        }
      }
    },
    created(){
      this.refreshList();
    },
    components: {
      commentEditor: {
        name: 'comment-editor',
        template: `
          <div class="bbn-w-100 bbn-radius appui-vcs-project-issues-comments-editor">
            <bbn-form :source="source"
                      :data="cp.formData"
                      :action="cp.root + 'actions/project/issue/comment/' + (!source.id ? 'insert' : 'edit')"
                      :windowed="false"
                      @success="cp.onSuccess"
                      :buttons="[{
                        text: _('Cancel'),
                        icon: 'nf nf-fa-times_circle',
                        action: cancel
                      }, 'submit']"
                      ref="form">
              <div v-if="!source.id"
                   class="bbn-bottom-sspace bbn-vmiddle">
                <i :class="{
                     'nf nf-md-lock bbn-red': !!source.private,
                     'nf nf-md-lock_open bbn-green': !source.private
                   }"/>
                <bbn-checkbox :label="_('Private')"
                              v-model="source.private"
                              :value="true"
                              :novalue="false"
                              class="bbn-left-sspace"/>
              </div>
              <bbn-rte height="30rem"
                       v-model="source.content"
                       :required="true"
                       @ready="!source.id ? cp.scrollEnd() : false"
                       class="bbn-w-100"/>
            </bbn-form>
          </div>
        `,
        props: {
          source: {
            type: Object
          }
        },
        data(){
          return {
            cp: this.closest('appui-vcs-project-issues-comments')
          }
        },
        methods: {
          cancel(){
            this.getRef('form').reset();
            this.cp.currentEdit = false;
            this.cp.commentForm = false
          }
        }
      }
    }
  }
})();