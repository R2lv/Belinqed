<template>
<div class="modal fade alert" id="alert-modal" tabindex="-1" role="dialog" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{title}}</h5>
			</div>
			<div v-if="text" class="modal-body">
				<div v-html="text"></div>
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
			title: "Confirm",
			text: ''
		}
	},
	mounted() {
		$(this.$el).on("hidden.bs.modal", this.onClose);
	},
	methods: {
		onClose() {
			this.buttons = [];
			this.title = "Confirm";
			this.text = '';
			if(this.exitCallback) {
				this.exitCallback();
			}
		},
		close() {
			$(this.$el).modal("hide");
		},
		open(data, callback, closeCallback) {
			this.title = data.title || "";
			this.text = data.text || "";
			$(this.$el).modal("show");
			this.buttons = [];

			this.buttons.push({
				label: this.lang("okay"),
				classes: ['btn', 'btn-alrt'],
				callback: () => {
					callback&&callback(true);
					this.close();
				}
			});

			this.buttons.push({
				label: this.lang("cancel"),
				classes: ['btn', 'btn-alrt'],
				callback: this.close
			});

			this.exitCallback = closeCallback;
		}
	}
}
</script>