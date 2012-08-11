Ext.define('Leadschat.view.account.AddToOwner', {
    extend: 'Ext.window.Window',

    height: 377,
    width: 502,
    title: 'Account',

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'form',
                    height: 267,
                    bodyPadding: 10,
                    title: '',
                    items: [
                        {
                            xtype: 'label',
                            text: 'To add an acount for this owner, assign 1 QA and assign the agents under the QA'
                        },
                        {
                            xtype: 'combobox',
                            name: 'qa_id',
                            fieldLabel: 'Quality Assurance',
                            anchor: '100%'
                        },
                        {
                            xtype: 'fieldset',
                            height: 198,
                            title: 'My Fields',
                            items: [
                                {
                                    xtype: 'combobox',
                                    name: 'agent_id',
                                    fieldLabel: 'Agents',
                                    anchor: '100%'
                                },
                                {
                                    xtype: 'button',
                                    text: 'Add',
                                    name: 'add'
                                },
                                {
                                    xtype: 'gridpanel',
                                    title: 'Selected Agents',
                                    columns: [
                                        {
                                            xtype: 'gridcolumn',
                                            dataIndex: 'agent_id',
                                            text: 'Agent #'
                                        },
                                        {
                                            xtype: 'datecolumn',
                                            width: 235,
                                            dataIndex: 'agent_name',
                                            text: 'Agent Name'
                                        },
                                        {
                                            xtype: 'actioncolumn',
                                            width: 109,
                                            items: [
                                                {

                                                }
                                            ]
                                        }
                                    ],
                                    viewConfig: {

                                    }
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