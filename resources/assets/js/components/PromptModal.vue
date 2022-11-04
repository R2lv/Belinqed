<template>
<div class="modal fade alert" id="alert-modal" tabindex="-1" role="dialog" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{title}}</h5>
			</div>
			<div class="modal-body">
				<div v-html="text"></div>
				<input type="text" class="form-control" v-model="value" v-if="single_line">
				<textarea class="prompt-textarea form-control" v-model="value" v-else></textarea>
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
			title: "BelinQed Alert",
			text: '',
			value: '',
			single_line: false
		}
	},
	mounted() {
		$(this.$el).on("hidden.bs.modal", this.onClose);
	},
	methods: {
		onClose() {
			this.buttons = [];
			this.title = "BelinQed Prompts";
			this.text = '';
			if(this.exitCallback) {
				this.exitCallback();
			}
			this.value = "";
		},
		close() {
			$(this.$el).modal("hide");
			this.value = "";
		},
		open(data, callback, closeCallback) {
			this.title = data.title || "";
			this.text = data.text || "";
			$(this.$el).modal("show");
			this.buttons = [];

			if(data.single_line) {
				this.single_line = true;
			}

			this.buttons.push({
				label: this.lang("okay"),
				classes: ['btn', 'btn-alrt'],
				callback: () => {
					callback&&callback(this.value);
					this.value = "";
					this.close();
				}
			});

			this.buttons.push({
				label: this.lang("close"),
				classes: ['btn', 'btn-alrt'],
				callback: this.close
			});

			this.exitCallback = closeCallback;
		}
	}
}
</script>