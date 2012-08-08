Ext.define("Leadschat.model.Owner", {
	extend:"Ext.data.Model",
	fields: [
	     {name: 'selected', type:'boolean'},
	     {name: 'owner_id', type: 'int'},
	     {name: 'first_name',  type: 'string'},
	     {name: 'last_name',   type: 'string'},
	     {name: 'website', type: 'string'},
	     {name: 'company', type: 'string'},
	     {name: 'email', type:'string'},
	     {name: 'username', type:'string'},
	     {name: 'password', type:'string'},
	     {name: 'activated', type:'string'},
	     {name: 'credits', type:'int'},
	     {name: 'owner_type', type:'string'},
	     {name: 'timezone_id', type:'int'},
	     {name: 'mobile', type:'string'},
	     {name: 'number_hits', type:'string'},
	     {name: 'approved', type:'boolean'},
	     {name: 'deleted', type:'boolean'},
	     {name: 'fullname_webmaster', type:'string'},
	     {name: 'email_webmaster', type:'string'},
	     {name: 'phone_webmaster', type:'string'},
	     {name: 'date_created', type:'string'},
	     {name: 'date_updated', type:'string'},
	     {name: 'timezone', type:'auto'},
	     {name: "address", type:"auto"}
	 ],
	 proxy:{
		type:"ajax",
		 api: {
		    create  : '/owners/new',
		    read    : '/owners/get',
		    update  : '/owners/update',
		    destroy : '/owners/destroy_action'
		}
		 
	 },
	 associations:[
	     {type:"hasOne", model:"Timezone", primaryKey: 'id', foreignKey: 'timezone_id'}          
	 ],
	 
})
