Ext.ns('CoralMedia.Admin.User');

CoralMedia.Admin.User.UsersTooltipEditor = Ext.extend(Ext.ux.TooltipEditor, {
    initComponent:function ()
    {
        let toolTipTreeLoader = new Ext.tree.TreeLoader({
            preloadChildren: true,
            dataUrl:'security/administration/users/load_roles',
            listeners:{
                'beforeload':{
                    fn:function (treeLoader, node)
                    {
                        return !!(treeLoader.baseParams.iduser);
                    }, scope:this
                }
            }
        });

        Ext.apply(this, {treeLoader: toolTipTreeLoader}, {});

        CoralMedia.Admin.User.UsersTooltipEditor.superclass.initComponent.call(this);
    },

    /**
     * Override.
     * Shows this tooltip at the currently selected grid row XY position.
     *
     * @param {Ext.data.Record} record The record to edit.
     * @param {Function} cb
     * @param {Object} scope
     */
    show:function (record, cb, scope)
    {
        CoralMedia.Admin.User.UsersTooltipEditor.superclass.show.call(this, record, cb, scope);
        if (record)
        {
            // set title
            this.tree.setTitle('User groups membership')
            this.tree.setIconClass('user-group-properties-icon');
            // reload
            this.tree.getLoader().baseParams.iduser = record.data.id;
            this.reloadTree();
        }
    },

    /**
     * Override.
     * The callback function is passed an array of the checked group ids.
     */
    onSaveClick:function ()
    {
        if (this.callback && this.scope)
        {
            var ns = this.tree.getChecked();
            var ids = [];
            Ext.each(ns, function (n)
            {
                ids.push(n.id);
            });
            if (ids.length > 0)
            {
                this.callback.call(this.scope, ids);
                this.hide();
            }
        }
    }
});