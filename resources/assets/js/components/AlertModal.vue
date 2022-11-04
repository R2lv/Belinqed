<template>
<div class="modal fade alert" id="alert-modal" tabindex="-1" role="dialog" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{title}}</h5>
			</div>
			<div class="modal-body" v-html="text"></div>
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
	},
	methods: {
		onClose() {
			this.buttons = [];
			this.title = "";
			this.text = '';
			if(this.exitCallback) {
				this.exitCallback();
			}
		},
		close() {
			$(this.$el).modal("hide");
		},
		open(title, text, buttons = {}) {
			this.title = title;
			this.text = text;
			$(this.$el).modal("show");
			if(Array.isArray(buttons)) {
				this.buttons = buttons;
			} else {
				this.buttons = [];

				if(buttons.showSuccess!==false)
					this.buttons.push({
						label: buttons.successLabel||this.lang("okay"),
						classes: buttons.successClasses||['btn', 'btn-alrt'],
						callback: buttons.successCallback||this.close
					});

				if(buttons.showClose)
					this.buttons.push({
						label: buttons.closeLabel||this.lang("close"),
						classes: buttons.closeClasses||['btn', 'btn-alrt'],
						callback: buttons.closeCallback||this.close
					});

				this.exitCallback = typeof buttons === "function" ? buttons : buttons.exitCallback||buttons.closeCallback;

				console.log(this.buttons);
			}
		}
	}
}
</script>