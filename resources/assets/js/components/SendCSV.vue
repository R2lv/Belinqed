<template>
<div class="modal fade alert" id="alert-modal" tabindex="-1" role="dialog" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{lang('company_public_job_detail_upload_csv')}}</h5>
			</div>
			<div class="modal-body">
				<dropzone :options="{acceptedFiles: 'video/*', maxFiles: 1}" ref="dropzone">{{lang('company_public_job_detail_drop_or_click')}}</dropzone>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alrt" @click="chosen">{{lang('send')}}</button>
			</div>
		</div>
	</div>
</div>
</template>
<script>
export default {
	data() {
		return {
			value: ''
		}
	},
	mounted() {
		$(this.$el).on("hidden.bs.modal", this.onClose);
	},
	methods: {
		onClose() {
			this.$refs.dropzone.dropzone.removeAllFiles(true);

		},
		close() {
			$(this.$el).modal("hide");
		},
		open() {
			$(this.$el).modal("show");
		},
		chosen() {
			if(this.$refs.dropzone.dropzone.files.length) {
				this.$emit("submit", this.$refs.dropzone.dropzone.files[0]);
			}
			this.close();
		}
	}
}
</script>