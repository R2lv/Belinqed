<template>
<div class="star-list" :class="{'hovering': hovering!==-1, 'readonly': readonly}">
	<span class="star" v-for="i in max" @click="set(i)" @mouseover="over(i)" @mouseout="out">
		<template v-if="i<=val || i<=hovering">&#9733;</template>
		<template v-else>&#9734;</template>
	</span>
</div>
</template>

<script>
export default {
	name: "StarSelect",
	props: {
		max: {
			default: 5,
			type: Number
		},
		value: {
			default: 0
		},
		readonly: {
			default: false,
			type: Boolean
		}
	},
	data() {
		return {
			val: 0,
			hovering: -1
		};
	},
	watch: {
		value(val) {
			this.val = val;
		}
	},
	mounted() {
		this.val = this.value;
	},
	methods: {
		set(val) {
			this.val = val;
			this.$emit("input", val);
			this.out();
		},
		over(val) {
			this.hovering = val;
		},
		out() {
			this.hovering = -1;
		}
	}
}
</script>

<style scoped>

</style>