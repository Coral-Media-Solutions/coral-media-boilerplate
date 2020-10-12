Ext.ns('CoralMedia.Admin.User');

CoralMedia.Admin.User.Grid = Ext.extend(Hydra.grid.GridPanel, {
    id: 'coral-media-admin-users',
    title: 'Users',
    sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
    cm: new Ext.grid.ColumnModel({
        defaults: {
            width: 120,
            sortable: true
        },
        columns: [
            {header: 'First Name', sortable: true, dataIndex: 'firstName', type: 'string'},
            {header: 'Last Name', sortable: true, dataIndex: 'lastName', type: 'string'},
            {header: 'Email', sortable: true, dataIndex: 'email', type: 'string'}
        ]
    }),

    initComponent: function()
    {
        let self = this;
        self.resource = '/api/security/users';
        self.store = self.configureStore();
        self.tbar = self.configureToolBar();
        self.bbar = self.configureBottomBar();

        CoralMedia.Admin.User.Grid.superclass.initComponent.call(this);
    },

    configureStore: function() {
        let self = this;
        return self.store||(
            new Ext.data.JsonStore({
                restful: true,
                proxy: new Ext.data.HttpProxy({url:self.resource}),
                idProperty: 'id',
                totalProperty: 'hydra:totalItems',
                root: 'hydra:member',
                fields: ['firstName', 'lastName', 'email'],
                baseParams: {
                    page: 1
                },
                paramNames: {
                    page: 'page'
                }
            })
        );
    },

    configureToolBar: function() {
        let self = this;
        return self.tbar||([
            {
                xtype: 'button',
                iconCls: 'list-add-icon',
                handler: self.onAddClick,
                ref:'../addButton',
                itemId:'addButton',
                scope: this
            },
            {
                xtype: 'button',
                iconCls: 'document-edit-icon',
                handler: self.onEditClick,
                ref:'../editButton',
                itemId:'editButton',
                scope: this,
                disabled:true
            },'-',
            {
                xtype: 'button',
                iconCls: 'edit-delete-icon',
                handler: self.onDeleteClick,
                ref:'../deleteButton',
                itemId:'deleteButton',
                scope: this,
                disabled: true
            },'->',
            {
                xtype: 'button',
                iconCls: 'document-export-icon',
                handler: Ext.emptyFn,
                ref:'../exportButton',
                itemId:'exportButton',
                scope: this
            }
        ]);
    },

    configureBottomBar: function() {
        let self = this;
        return this.bbar||(
            new Hydra.PagingToolbar({
                pageSize: 15,
                store: self.store,
                displayInfo: true
            })
        );
    },

    setFormContainer: function (action, options) {
        let self = this;
        self.formContainer = new Ext.Window(Ext.apply({
            layout: 'fit',
            height: 320,
            width: 640,
            resizable: false,
            modal: true,
            title: action.charAt(0).toUpperCase() +
                action.slice(1) + ' User',
            items:[
                new CoralMedia.Admin.User.Form({
                    parentGrid: this,
                    action: action
                })
            ]
        }, options));
    }
});
