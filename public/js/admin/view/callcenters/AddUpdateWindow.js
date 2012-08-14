Ext.define('Leadschat.view.callcenters.AddUpdateWindow', {
    extend: 'Ext.window.Window',
    alias:"widget.callcenters_addupdatewindow",
    height: 225,
    width: 504,
    buttons:[{
	   	 text:"Save",
		 icon:"/js/ext/examples/shared/icons/fam/disk.png",
		 name:"save"
	 },
	 {
		 text:"Close",
		 icon:"/js/ext/examples/shared/icons/fam/cross.png",
		 name:"close"
	 }], 
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