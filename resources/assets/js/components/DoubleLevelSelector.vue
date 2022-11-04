<template>
	<div class="dublicat-box">

		<div class="col-md-6 col-sm-12">
			<div class="input-group">
				<a href="#" class="input-group-addon" @click.prevent="$emit('delete')">X</a>
				<div class="input-wrapper">
					<select2 ref="select" class="no-mar" :placeholder="placeholder" :list="list" @input="update" :display-field="displayField" v-model="val" />
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-12">
			<div class="form-group">
			<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-bullhorn"></i></div>
				<select2 ref="select" class="no-mar" :list="levelList" displayField="name" :placeholder="level1Placeholder" v-model="value.pivot[levelField1]" :id-model="true" />
			</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-12">
			<div class="input-group">
				<div class="input-group-addon"><i class="fa fa-pencil"></i></div>
				<select2 ref="select" class="no-mar" :list="levelList" displayField="name" :placeholder="level2Placeholder" v-model="value.pivot[levelField2]" :id-model="true" />
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "LevelSelector",
	data() {
		return {
			val: ''
		}
	},
	props: {
		value: Object,
		list: Array,
		levelList: Array,
		displayField: {
			default: 'name',
			type: String
		},
		levelField1: {
			default: 'Level1',
			type: String
		},
		levelField2: {
			default: 'Level2',
			type: String
		},
		level1Placeholder: {
			default: 'Select level 1',
			type: String
		},
		level2Placeholder: {
			default: 'Select level 2',
			type: String
		},
		placeholder: {
			default: "Select language ",
			type: String
		}
	},
	created() {
		console.log("ASF");
	},
	mounted() {
		this.val = this.value;
	},
	watch: {
		value(value) {
			this.val = value;
		}
	},
	methods: {
		update(item) {
			this.$emit("input", {
				[this.displayField]: item[this.displayField],
				id: item.id,
				pivot: {
					[this.levelField1]: this.value.pivot[this.levelField1],
					[this.levelField2]: this.value.pivot[this.levelField2]
				}
			});
		}
	}
}
</script>

<style scoped lang="scss">
.input-wrapper {
	float: left;
	width: 100%;

	.select-list {
		position: absolute;
		left: 0;
		top: 0;
		list-style: none;
		margin: 0;
		padding: 0;
		border: 1px solid #F1F1F1;
		border-top: none;
		width: 100%;
		max-height: 200px;
		overflow-y: auto;
		z-index: 10;

		li a {
			display: block;
			padding: 5px;
			background: #FFF;
			border-bottom: 1px solid #F1F1F1;
		}

		li:last-child a {
			border-bottom: none;
		}
	}

}
</style>