Ext.define('Leadschat.view.agents.AddUpdateWindow', {
    extend: 'Ext.window.Window',

    height: 315,
    width: 635,
    title: 'Add User/Update User',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'form',
                    height: 234,
                    bodyPadding: 10,
                    title: '',
                    items: [
                        {
                            xtype: 'textfield',
                            name: 'first_name',
                            fieldLabel: 'First Name',
                            anchor: '100%'
                        },
                        {
                            xtype: 'textfield',
                            name: 'last_name',
                            fieldLabel: 'Last Name',
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
                            name: 'confirm_password',
                            fieldLabel: 'Confirm Password',
                            anchor: '100%'
                        },
                        {
                            xtype: 'combobox',
                            name: 'call_center_id',
                            fieldLabel: 'Call Center',
                            anchor: '100%'
                        },
                        {
                            xtype: 'combobox',
                            name: 'type',
                            fieldLabel: 'Type',
                            anchor: '100%'
                        }
                    ]
                }
            ]
        });

        me.callParent(arguments);
    }

});