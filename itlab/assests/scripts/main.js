var MYAPP = (function () {

	var available_equipment_list = [],
		return_equipment_list=[];
	return {
		SETTING : {
			SESSIONKEY : 'login_id',
			BASE_HOST : "http://localhost:8888/itlab_project/itlab/",
		},
		addEquipment : function(e_obj) {

			if(e_obj.status === 'available') {
				for (var i = 0 ; i < available_equipment_list.length ; i++) {
					if(available_equipment_list[i].id === e_obj.id) {
						return false;
					}
				}
				available_equipment_list.push(e_obj);
			} else if(e_obj.status === 'loaned') {
				for (var i = 0 ; i < return_equipment_list.length ; i++) {
					if(return_equipment_list[i].id === e_obj.id) {
						return false;
					}
				}
				return_equipment_list.push(e_obj);
			}
			
			return true;
		},
		removeEquipment : function(e_id) {
			for (var i = 0 ; i < available_equipment_list.length ; i++) {
				if(available_equipment_list[i].id === e_id) {
					available_equipment_list.splice(i, 1);
					// alert('Remove list Success!');
					break;
				}
			}
			for (var i = 0 ; i < return_equipment_list.length ; i++) {
				if(return_equipment_list[i].id === e_id) {
					return_equipment_list.splice(i, 1);
					// alert('Remove list Success!');
					break
				}
					
			}
		},
		getEquipments : function () {
			return [available_equipment_list,return_equipment_list];
		},
		EquipmentListIsEmpty : function() {
			return $.isEmptyObject(available_equipment_list) && $.isEmptyObject(return_equipment_list);
		},
	};
})();

	