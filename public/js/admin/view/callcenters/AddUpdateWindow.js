Ext.define('Leadschat.view.callcenters.AddUpdateWindow', {
    extend: 'Ext.window.Window',

    height: 225,
    width: 504,
    title: 'Add New Call Center/Update Call Center',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'form',
                    height: 135,
                    bodyPadding: 10,
                    title: '',
                    items: [
                        {
                            xtype: 'textfield',
                            name: 'name',
                            fieldLabel: 'Name',
                            anchor: '100%'
                        },
                        {
                            xtype: 'textfield',
                            name: 'username',
                            fieldLabel: 'Username',
                            anchor: '100%'
                        },
                        {
                            xtype: 'textfield',
                            inputType: 'password',
                            name: 'password',
                            fieldLabel: 'Password',
                            anchor: '100%'
                        },
                        {
                            xtype: 'textfield',
                            inputType: 'password',
                            name: 'confirm_password',
                            fieldLabel: 'Confirm Password',
                            anchor: '100%'
                        }
                    ]
                }
            ]
        });

        me.callParent(arguments);
    }

});