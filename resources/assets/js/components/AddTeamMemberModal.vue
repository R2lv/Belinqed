<template>
	<div class="modal fade" id="addTeamMemberModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div style="padding: 40px">
						<form @submit.prevent="finish">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" id="name" v-model="name" class="form-control" placeholder="Member name">
							</div>
							<div class="form-group">
								<label for="position">Position</label>
								<input type="text" id="position" v-model="position" class="form-control" placeholder="Member position">
							</div>
							<div class="form-group">
								<label for="about">About</label>
								<textarea id="about" v-model="about" class="form-control" placeholder="About Member"></textarea>
							</div>
							<div class="form-group">
								<label for="image">Image</label>
								<input type="file" id="image" ref="image" class="form-control" title="Member Photo">
							</div>
							<div class="form-group">
								<label for="video">Video</label>
								<input type="file" id="video" ref="video" class="form-control" title="Member Video">
							</div>
							<div class="form-group">
								<button @click.prevent="finish" class="btn btn-primary">Add</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "AddTeamMemberModal",
	data() {
		return {
			name: "",
			position: "",
			about: ""
		}
	},
	methods: {
		show() {
			$(this.$el).modal("show");
		},
		hide() {
			$(this.$el).modal("hide");
		},
		finish() {
			this.$emit("add", {
				name: this.name,
				position: this.position,
				about: this.about,
				image_file: this.$refs.image.files[0],
				video_file: this.$refs.video.files[0]
			});
			this.hide();
			this.reset();
		},
		reset() {
			this.name = "";
			this.position = "";
			this.$refs.image.value = "";
			this.$refs.video.value = "";
		}
	}
}
</script>