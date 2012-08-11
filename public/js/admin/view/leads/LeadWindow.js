Ext.define('Leadschat.view.leads.LeadWindow', {
    extend: 'Ext.window.Window',

    height: 481,
    width: 700,
    title: 'Lead',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'panel',
                    height: 364,
                    layout: {
                        type: 'column'
                    },
                    title: '',
                    items: [
                        {
                            xtype: 'form',
                            height: 358,
                            margin: '0, 5, 0, 0',
                            bodyPadding: 10,
                            title: 'Leads Information',
                            columnWidth: 0.5,
                            name: 'leads_information',
                            items: [
                                {
                                    xtype: 'textfield',
                                    name: 'name',
                                    fieldLabel: 'Name',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'email_address',
                                    fieldLabel: 'Email Address',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'service_needed',
                                    fieldLabel: 'Service Needed',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'datefield',
                                    name: 'service_required',
                                    fieldLabel: 'Service Required',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'address1',
                                    fieldLabel: 'Address 1',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'city',
                                    fieldLabel: 'City',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'state',
                                    fieldLabel: 'State',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'textfield',
                                    name: 'postal_code',
                                    fieldLabel: 'Postal Code',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'combobox',
                                    fieldLabel: 'Country',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'slider',
                                    value: 6,
                                    fieldLabel: 'Urgency',
                                    maxValue: 5,
                                    anchor: '100%'
                                }
                            ]
                        },
                        {
                            xtype: 'form',
                            height: 358,
                            bodyPadding: 10,
                            title: 'Chat Information',
                            columnWidth: 0.5,
                            items: [
                                {
                                    xtype: 'label',
                                    text: 'Chat'
                                },
                                {
                                    xtype: 'textareafield',
                                    height: 280,
                                    fieldLabel: '',
                                    anchor: '100%'
                                }
                            ]
                        }
                    ]
                }
            ]
        });

        me.callParent(arguments);
    }

});