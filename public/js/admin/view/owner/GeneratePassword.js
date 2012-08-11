Ext.define('Leadschat.view.owner.GeneratePassword', {
    extend: 'Ext.form.Panel',

    height: 164,
    width: 489,
    bodyPadding: 10,
    title: 'Generate Password',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'textfield',
                    inputType: 'password',
                    name: 'new_password',
                    fieldLabel: 'New Password',
                    anchor: '100%'
                },
                {
                    xtype: 'textfield',
                    inputType: 'password',
                    name: 'confirm_password',
                    fieldLabel: 'Confirm Password',
                    anchor: '100%'
                }
            ],
            dockedItems: [
                {
                    xtype: 'container',
                    padding: 5,
                    dock: 'bottom',
                    items: [
                        {
                            xtype: 'button',
                            text: 'Create Password',
                            name: 'create-password'
                        }
                    ]
                }
            ]
        });

        me.callParent(arguments);
    }

});