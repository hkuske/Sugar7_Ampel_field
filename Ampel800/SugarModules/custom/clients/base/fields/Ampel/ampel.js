/*********************************************************************************
AMPEL CONTROLLER
 ********************************************************************************/
({
	plugins : ['Tooltip'],

	_render : function () {
		var action = "view";
		var field_val = 0;
		if (this.model.has(this.name)) {
			field_val = this.model.get(this.name);
			if (field_val === '')
				field_val = 0;
		}
		if (this.def.link && this.def.route) {
			action = this.def.route.action;
		}
		if (!app.acl.hasAccessToModel(action, this.model)) {
			this.def.link = false;
		}
		if (this.def.link) {
			this.href = this.buildHref();
		}

		if ((parseInt(field_val) > 0) && (parseInt(field_val) < parseInt(this.def.range_min))) {
			this.def.ampel = "custom/include/SugarFields/Fields/Ampel/ampel_r.png";
		} else
			if ((parseInt(field_val) >= parseInt(this.def.range_min)) && (parseInt(field_val) < parseInt(this.def.range_max))) {
				this.def.ampel = "custom/include/SugarFields/Fields/Ampel/ampel_y.png";
			} else
				if (parseInt(field_val) >= parseInt(this.def.range_max)) {
					this.def.ampel = "custom/include/SugarFields/Fields/Ampel/ampel_g.png";
				} else {
					this.def.ampel = "custom/include/SugarFields/Fields/Ampel/ampel_b.png";
				}
		app.view.Field.prototype._render.call(this);
	},
	buildHref : function () {
		var defRoute = this.def.route ? this.def.route : {},
		module = this.model.module || this.context.get('module');
		return '#' + app.router.buildRoute(module, this.model.id, defRoute.action, this.def.bwcLink);
	},
	unformat : function (field_val) {
		return _.isString(field_val) ? field_val.trim() : field_val;
	}
})
