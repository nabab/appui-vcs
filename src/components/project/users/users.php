<div class="appui-vcs-project-users bbn-alt-background bbn-overlay bbn-padded">
  <div class="bbn-100">
    <div class="bbn-overlay bbn-flex-height">
      <div class="
             bbn-upper
             bbn-b
             bbn-spadded
             bbn-c
             bbn-lg
             bbn-tertiary-text-alt
             bbn-background
             bbn-radius
             bbn-bottom-space
             appui-vcs-box-shadow
           "><?=_('Users')?></div>
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
        </bbn-table>
      </div>
    </div>
  </div>
</div>