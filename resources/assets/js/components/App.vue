<template>
<div class="wrapper">

	<t-header ref="theader" />

	<router-view />

	<t-footer />
	<alert-modal ref="alert" />
	<video-modal ref="video" />
	<prompt-modal ref="prompt" />
	<confirm-modal ref="confirm" />
</div>
</template>
<script>

import THeader from './Header';
import TFooter from './Footer';


export default {
	created() {
		this.$store.dispatch("initialFetch");

		if(this.$auth.isLoggedIn()) {
			if(this.$auth.isCompany()) {
				this.$store.dispatch("initialFetchCompany");
			} else {
				this.$store.dispatch("initialFetchUser");
			}
		}
	},
	mounted() {



		this.$root.$alert = this.$refs.alert;
		this.$root.$prompt = this.$refs.prompt;
		this.$root.$confirm = this.$refs.confirm;
		this.$root.$video = this.$refs.video;
	},
	components: {
		THeader,
		TFooter
	}
}
</script>