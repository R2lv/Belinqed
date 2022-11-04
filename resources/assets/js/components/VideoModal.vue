<template>
<div class="modal fade alert" id="alert-modal" tabindex="-1" role="dialog" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{title}}</h5>
			</div>
			<div class="modal-body">
				<video id="video"  height="450" controls preload="auto" width="100%" style="width: 100%" class="video-js vjs-default-skin"></video>
			</div>
			<div class="modal-footer">
				<button v-for="btn in buttons" type="button" :class="btn.classes" @click.prevent="btn.callback?btn.callback():close">{{btn.label}}</button>
			</div>
		</div>
	</div>
</div>
</template>
<script>
export default {
	data() {
		return {
			exitCallback: null,
			buttons: [],
			title: "",
			text: ''
		}
	},
	mounted() {
		$(this.$el).on("hidden.bs.modal", this.onClose);
		this.videoJs = videojs(this.$el.querySelector("#video"));
	},
	methods: {
		onClose() {
			this.buttons = [];
			this.title = "";
			this.text = '';
			if(this.exitCallback) {
				this.exitCallback();
			}
			this.videoJs.pause();
		},
		close() {
			$(this.$el).modal("hide");
		},
		open(title, src) {
			this.title = title;

			this.buttons = [{
				label: this.lang("close"),
				classes: ['btn', 'btn-alrt'],
				callback: this.close
			}];

			this.videoJs.src(src);

			$(this.$el).modal("show");
		}
	}
}
</script>