Ext.ns('CoralMedia.Admin.User');

CoralMedia.Admin.User.Form = Ext.extend(Ext.form.FormPanel,{
    defaults:{
        anchor: '-20',
        msgTarget: 'side',
        xtype: 'textfield',
        allowBlank: false
    },

    padding: '10',
    action: null,
    /**
     * @var Ext.grid.GridPanel
     */
    parentGrid: null,
    jsonData: null,

    initComponent:function ()
    {
        let self = this;
        self.buttons = this.configureDefaultButtons();
        self.items = this.configureFormFields();
        CoralMedia.Admin.User.Form.superclass.initComponent.call(this);
        if (self.action === 'update') {
            self.jsonData  = self.parentGrid.getSelectionModel().getSelected().json;
            self.getForm().loadRecord(self.parentGrid.getSelectionModel().getSelected());
        }
        self.getForm().on('beforeaction', function (form, action) {
            if(action.type === 'jsonSubmit' && !Ext.isArray(form.getValues().roles)) {
                let params = form.getValues();
                action.overwriteParams = {roles: [params.roles]};
            }
        }, this)
    },

    configureFormFields: function () {
        let self = this;
        return self.items||([
            {
                xtype: 'textfield',
                fieldLabel: 'First Name',
                name: 'firstName'
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Last Name',
                name: 'lastName'
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Email',
                name: 'email',
                vtype: 'email'
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Password',
                name: 'password',
                inputType: 'password'
            },
            new Ext.ux.form.SuperBoxSelect({
                fieldLabel: 'System Roles',
                emptyText: 'Select...',
                resizable: false,
                id: 'superbox-roles',
                name: 'roles',
                store: new Ext.data.ArrayStore({
                    fields: ['value', 'label'],
                    data: [
                        ['ROLE_USER', 'ROLE_USER'],
                        ['ROLE_API', 'ROLE_API'],
                        ['ROLE_ADMIN', 'ROLE_ADMIN'],
                        ['ROLE_SUPER_ADMIN', 'ROLE_SUPER_ADMIN']
                    ],
                    autoLoad: true
                }),
                mode: 'local',
                autoCreate: true,
                displayField: 'label',
                valueField: 'value',
                forceSelection : true,
                listeners: {
                    'afterrender': function (superbox) {
                        superbox.setValue(this.jsonData.roles)
                    },
                    scope: this
                }
            })
        ])
    },

    configureDefaultButtons:function()
    {
        let self = this;
        return self.buttons||([
            {
                xtype:'button',
                scope:this,
                iconCls: 'document-save-icon',
                handler: self.onSaveClick,
                text: 'Save',
                ref: '../saveButton'

            },
            {
                xtype:'button',
                scope:this,
                iconCls: 'dialog-ok-apply-icon',
                handler: self.onApplyClick,
                text: 'Apply',
                ref: '../applyButton'
            },
            {
                xtype:'button',
                scope:this,
                iconCls: 'dialog-cancel-icon',
                handler: self.onCancelClick,
                text: 'Cancel',
                ref: '../cancelButton'
            }
        ]);
    },

    onSaveClick:function(button, event)
    {
        let self = this;
        self.getForm().doAction('jsonSubmit', {
            url: (self.action === 'update')?self.jsonData['@id']: self.parentGrid.resource,
            method: (self.action === 'update')?'PATCH':'POST',
            headers: {
                'Content-Type': (self.action === 'update')?'application/merge-patch+json':'application/json;charset=utf-8'
            },
            clientValidation: true,
            success: function(form, action) {
                self.parentGrid.getStore().reload({
                    callback:function(records, options, success) {
                        self.parentGrid.getView().refresh(true);
                    },scope:this,
                });
                self.onCancelClick(button, event);
            },
            scope:this
        });
    },

    onApplyClick:function(button, event)
    {
        let self = this;
        self.getForm().doAction('jsonSubmit', {
            url: (self.action === 'update')?self.jsonData['@id']: self.parentGrid.resource,
            method: (self.action === 'update')?'PATCH':'POST',
            headers: {
                'Content-Type': (self.action === 'update')?'application/merge-patch+json':'application/json;charset=utf-8'
            },
            clientValidation: true,
            success: function(form, action) {
                self.parentGrid.getStore().reload({
                    callback:function(records, options, success) {
                        self.parentGrid.getView().refresh(true);
                    },scope:this
                });
                if (self.action === 'create') {
                    form.reset();
                }
            },
            scope:this
        });
    },

    onCancelClick:function(button, event)
    {
        let self = this;
        self.ownerCt.hide();
        self.ownerCt.destroy();
    }
});