<template>
<div class="spinner-lock">
	<div class="spinner" :style="spinnerStyle">
		<div class="double-bounce1"></div>
		<div class="double-bounce2"></div>
	</div>
</div>
</template>

<script>
export default {
	name: "spinner",
	props: {
		spinnerStyle: {
			default() {
				return {}
			}
		}
	}
}
</script>