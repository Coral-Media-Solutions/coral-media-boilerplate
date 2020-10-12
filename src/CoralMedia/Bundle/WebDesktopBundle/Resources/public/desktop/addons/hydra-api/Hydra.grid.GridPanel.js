Ext.ns('Hydra.grid');
Hydra.grid.GridPanel = Ext.extend(Ext.grid.GridPanel, {
    stripeRows: true,
    viewConfig: {
        forceFit: true
    },
    loadMask: true,
    resource: '/',

    formContainer: null,

    initComponent: function()
    {
        let self = this;

        Hydra.grid.GridPanel.superclass.initComponent.call(this);

        self.getSelectionModel().on('rowselect', self.onRowSelect, this);
        self.getSelectionModel().on('rowdeselect', self.onRowDeSelect, this);

        self.getStore().load();
    },

    configureStore: function() {
    },

    configureToolBar: function() {
    },

    configureBottomBar: function() {
    },

    showMask: function (msg)
    {
        this.body.mask(msg, 'x-mask-loading');
    },

    hideMask: function ()
    {
        this.body.unmask();
    },

    toggleButtons: function(status)
    {
        let self = this;
        if(status === true) {
            self.deleteButton.enable();
            self.editButton.enable();
        }
        if(status === false) {
            self.deleteButton.disable();
            self.editButton.disable();
        }
    },

    onRowSelect:function(sm, rowIndex, record){
        this.toggleButtons(true);
    },

    onRowDeSelect:function(sm, rowIndex, record){
        this.toggleButtons(false);
    },

    setFormContainer: function (action, options) {
        let self = this;
        self.formContainer = new Ext.Window(Ext.apply({
            layout: 'fit',
            height: 240,
            width: 320,
            resizable: false,
            modal: true,
            title: action.charAt(0).toUpperCase() +
                action.slice(1) ,
            items:[
                new CoralMedia.Admin.User.Form({
                    parentGrid: this,
                    action: action
                })
            ]
        }, options));
    },

    onAddClick:function(button, event)
    {
        this.setFormContainer('create', {iconCls:button.iconCls});
        this.formContainer.show();
    },

    onEditClick:function(button, event)
    {
        this.setFormContainer('update', {iconCls:button.iconCls});
        this.formContainer.show();
    },

    onDeleteClick:function (button, event)
    {
        let self = this;
        let resource = self.getSelectionModel().getSelected().json['@id'];
        Ext.MessageBox.confirm('Are you sure? Please confirm',
            'Are you sure you want to delete selected record?', function (btn) {
                if (btn === "yes")
                {
                    this.showMask('Deleting' + '...');

                    Ext.Ajax.request({
                        callback:function (options, success, response)
                        {
                            this.hideMask();
                            if (response.status === 204) {
                                self.getSelectionModel().clearSelections();
                                self.getStore().load();
                            } else {
                                Ext.MessageBox.alert(
                                    'Error', response.statusMessage
                                );
                            }
                        },
                        method: 'DELETE',
                        scope:this,
                        url: resource
                    });
                }
            }, this);
    },

    onExportClick:function (button, event) {
    }
});