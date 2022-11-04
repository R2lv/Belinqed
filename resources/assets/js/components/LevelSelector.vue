<template>
	<div>

		<div class="col-md-9 col-sm-12">
			<div class="input-group">
				<a href="#" class="input-group-addon" @click.prevent="$emit('delete')">X</a>
				<div class="input-wrapper">
					<select2 ref="select" class="no-mar" :placeholder="placeholder" :list="list" @input="update" :display-field="displayField" v-model="val" />
				</div>
			</div>
		</div>
		<div class="col-md-3 col-sm-12">
			<div class="input-group">

				<!--<div class="dropdown">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						<template v-if="value.pivot[levelField]">
							{{levelText}} {{value.pivot[levelField]}}/10
						</template>
						<template v-else>
							{{levelPlaceholder}}
						</template>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li v-for="i in 10">
							<a href="#" @click.prevent="value.pivot[levelField] = i">
								<template v-for="x in i">&#9733;</template>
							</a>
						</li>
					</ul>
				</div>-->

				<div class="star-select-wrapper" v-if="selectType==='stars'">
					<star-select :max="5" v-model="value.pivot[levelField]" />
				</div>
				<div v-else>
					<select2 ref="select" class="no-mar" :list="levelList" displayField="name" :placeholder="levelPlaceholder" v-model="value.pivot[levelField]" />
				</div>

			</div>
		</div>
	</div>
</template>

<script>
import StarSelect from "./StarSelect";
export default {
	name: "LevelSelector",
	components: {StarSelect},
	data() {
		return {
			val: ''
		}
	},
	props: {
		value: Object,
		list: Array,
		displayField: {
			default: 'name',
			type: String
		},
		levelField: {
			default: 'knowledge_level',
			type: String
		},
		levelPlaceholder: {
			default: 'Select knowledge level',
			type: String
		},
		placeholder: {
			default: "Please select",
			type: String
		},
		levelList: {
			default: () => [],
			type: Array
		},
		selectType: {
			default: 'stars',
			type: String
		},
		debug: {
			default: false
		}
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
					[this.levelField]: this.value.pivot[this.levelField]
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