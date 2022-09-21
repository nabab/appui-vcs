<div class="appui-vcs-project-users bbn-alt-background bbn-overlay bbn-padded">
  <div class="bbn-100">
    <div class="bbn-overlay bbn-flex-height">
    <div class="bbn-spadded bbn-background bbn-radius bbn-bottom-space appui-vcs-box-shadow bbn-vmiddle bbn-flex-width">
        <div class="bbn-alt-background bbn-vmiddle bbn-xspadded bbn-radius bbn-flex-fill">
          <bbn-button icon="nf nf-fa-plus"
                      :text="_('Add')"
                      @click="insertUser"/>
        </div>
        <div class="bbn-upper bbn-b bbn-lg bbn-tertiary-text-alt bbn-left-lspace bbn-right-space"
             v-text="_('Users')"/>
      </div>
      <div class="bbn-flex-fill">
        <bbn-table :source="tableSource"
                   class="bbn-background bbn-radius appui-vcs-box-shadow"
                   :scrollable="true"
                   :title-groups="[{
                     text: _('Added'),
                     value: 'added'
                   }]"
                   >
          <bbns-column field="avatar"
                       title=" "
                       cls="bbn-c"
                       :width="60"
                       :component="$options.components.avatar"/>
          <bbns-column field="id"
                       :title="_('ID')"
                       :width="40"
                       cls="bbn-c"/>
          <bbns-column field="name"
                       :title="_('Name')"
                       :render="renderName"/>
          <bbns-column field="role"
                       :title="_('Role')"
                       :width="180"
                       cls="bbn-c"/>
          <bbns-column field="created"
                       :title="_('At')"
                       group="added"
                       :width="180"
                       cls="bbn-c"
                       :render="renderDate"/>
          <bbns-column field="author"
                       :title="_('By')"
                       group="added"
                       :width="240"
                       :component="$options.components.author"/>
          <bbns-column :buttons="[{
                         text: _('Delete'),
                         icon: 'nf nf-fa-trash',
                         notext: true,
                         action: removeUser,
                         class: 'bbn-white bbn-bg-red'
                       }]"
                       :width="50"
                       cls="bbn-c"/>
        </bbn-table>
      </div>
    </div>
  </div>
</div>