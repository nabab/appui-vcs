<div class="appui-vcs-project-branches bbn-alt-background bbn-overlay bbn-padding">
  <div class="bbn-100">
    <div class="bbn-overlay bbn-flex-height">
      <div class="bbn-spadding bbn-background bbn-radius bbn-bottom-space appui-vcs-box-shadow bbn-vmiddle bbn-flex-width">
        <div class="bbn-alt-background bbn-vmiddle bbn-xspadding bbn-radius bbn-flex-fill">
          <bbn-button icon="nf nf-fa-plus"
                      :label="_('Add')"
                      @click="insertBranch"/>
        </div>
        <div class="bbn-upper bbn-b bbn-lg bbn-tertiary-text-alt bbn-left-lspace bbn-right-space"
             v-text="_('Branches')"/>
      </div>
      <div class="bbn-flex-fill">
        <bbn-table :source="tableSource"
                   class="bbn-background bbn-radius appui-vcs-box-shadow"
                   :title-groups="[{
                     text: _('Last action'),
                     value: 'lastaction'
                   }]"
                   :scrollable="true">
          <bbns-column field="default"
                       :label="_('Def.')"
                       :flabel="_('Default')"
                       :render="renderDefault"
                       cls="bbn-c"
                       :width="60"/>
          <bbns-column field="name"
                       :label="_('Name')"/>
          <bbns-column field="author"
                       :label="_('User')"
                       group="lastaction"
                       :width="250"
                       :component="$options.components.author"/>
          <bbns-column field="created"
                       :label="_('Date')"
                       group="lastaction"
                       :render="renderCreated"
                       :width="130"
                       cls="bbn-c"/>
          <bbns-column :buttons="[{
                         text: _('Delete'),
                         icon: 'nf nf-fa-trash',
                         notext: true,
                         action: removeBranch,
                         class: 'bbn-white bbn-bg-red'
                       }]"
                       :width="50"
                       cls="bbn-c"/>
        </bbn-table>
      </div>
    </div>
  </div>
</div>