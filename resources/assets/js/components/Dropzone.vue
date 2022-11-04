<template>
<form action="/upload-target" class="dz-clickable profile-pic">
	<label>
		<!--<input type="file" style="opacity: 0; width: 100%; height: 100%; left: 0; top: 0; position:absolute;">-->
		<span class="dz-default dz-message" style="cursor: pointer; padding: 20px 0; display: inline-block;">
		<i class="fa fa-cloud-upload"></i>
		<span><slot /></span>
	</span>
	</label>
</form>
</template>

<script>
export default {
	name: "dropzone",
	data() {
		return {
			dropzone: null
		}
	},
	mounted() {
		let self = this;
		this.dropzone = new Dropzone(this.$el, _(this.options).defaults({
			url: '/',
			addRemoveLinks: true,
			// acceptedFiles: "video/*",
			// autoProcessQueue: false,
			autoQueue: false,
			init() {
				this.on("error", function(file) {
					self.$emit("dz:error", ...arguments);
				});

				this.on("maxfilesexceeded", (file) => {
					this.removeFile(file);
				});

				setTimeout( () => {$(self.$el).addClass("dropzone")},1);
			}
		}).value());






	},
	props: {
		options: {
			default() {
				return {};
			}
		}
	}
}
</script>
<style scoped>
.dropzone {
	width: 100%;
}
</style>