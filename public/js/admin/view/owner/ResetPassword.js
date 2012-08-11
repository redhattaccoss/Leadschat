Ext.define('Leadschat.view.owner.ResetPassword', {
    extend: 'Ext.form.Panel',

    height: 250,
    width: 400,
    bodyPadding: 10,
    title: 'Reset Password',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'label',
                    margin: '',
                    text: 'An email will be sent to the email. Please check the email complete the reset password'
                },
                {
                    xtype: 'textfield',
                    name: 'email_address',
                    fieldLabel: 'Email Address',
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
                            text: 'Reset Password',
                            name: 'reset'
                        }
                    ]
                }
            ]
        });

        me.callParent(arguments);
    }

});