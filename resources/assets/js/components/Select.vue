<template>
<div class="select2-belinqed-wrapper">
	<select class="form-control">
		<option></option>
		<option v-for="item in list" :value="item[idField]" :key="item[idField]">{{item[displayField]}}</option>
	</select>
</div>
</template>

<script>
export default {
	name: "Select",
	props: {
		value: {},
		list: Array,
		placeholder: {
			default: "Please select",
			type: String,
		},
		displayField: {
			default: "title",
			type: String
		},
		idField: {
			default: "id",
			type: String
		},
		idModel: {
			default: false,
			type: Boolean
		},
		options: {
			default() {
				return {};
			},
			type: Object
		},
		debug: false
	},
	watch: {
		value(value) {
			this.setValue();
		},
		list(list) {
			if(this.value)
				this.setValue();
		}
	},
	mounted() {
		const self = this;
		$(this.$el).find("select").select2(_(this.options).defaults({
			placeholder: this.placeholder,
			minimumResultsForSearch: 7,
			containerCssClass: "select2-belinqed",
			dropdownParent: $(this.$el),
		}).value())
		.on("select2:select", function() {
			let val = self.idModel ? $(this).val() : self.transformValue($(this).val());
			self.$emit("input", val);
		});


		if(this.list && this.value) {
			this.setValue();
		}

		// console.log(this.placeholder);
	},
	methods: {
		setValue() {
			setTimeout(()=> {
				if(!this.idModel)
					$(this.$el).find("select").val(this.reverseTransformValue(this.value)).trigger("change");
				else
					$(this.$el).find("select").val(this.value).trigger("change");
			});
		},
		transformValue(val) {
			// noinspection EqualityComparisonWithCoercionJS
			let res = this.options.multiple ? _(this.list).filter(item => _(val).some(v => v==item[this.idField])).value()
				: _(this.list).find(item => item[this.idField]==val);

			// console.log("Transform", val, res, this.options.multiple);
			return res;
		},
		reverseTransformValue(val) {
			let res = this.options.multiple ? _(val).map(v => v[this.idField]).value()
				: val[this.idField];

			// console.log("rTransform", val, res, this.options.multiple);
			return res;
		}
	}
}
</script>