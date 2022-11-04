<template>
	<!-- Sign Up Window Code -->
	<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="tab" role="tabpanel">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" :class="{'active':isLoginActive}"><a class="signInBtn" @click="isLoginActive=true" href="#login" role="tab" data-toggle="tab">{{ lang('sign_in')}}</a></li>
							<li role="presentation" :class="{'active':!isLoginActive}"><a class="signUpBtn" @click="isLoginActive=false" href="#register" role="tab" data-toggle="tab">{{lang('sign_up')}}</a></li>
						</ul>
						<!-- Tab panes -->
						<div class="tab-content spinner-holder" id="myModalLabel2">
							<login />
							<registration ref="registrationForm" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import api from '../api';
import {mapState} from 'vuex';
export default {
	data() {
		return {

			isLoginActive:true
		}
	},
	mounted() {
		if(this.$route.query.action === 'signup') {
			$("a[role=tab][href='#register']").tab('show');
			$("#signup").modal("show");
		} else if(this.$route.query.action === 'signin' ) {
			$("#signup").modal("show");
		}
		let self = this;

	},
	methods: {
		switchTabs(bool=true){
			this.isLoginActive = bool;
		},
		signInClick(){
			$(".signInBtn").click();
		},
		signUpClick(){
			$(".signUpBtn").click();
		}
	},
	computed: {
		...mapState(['countries']),
	},
	watch: {
		isLoginActive: function(newValue, oldValue){
			if(this.isLoginActive){
				this.signInClick();
			}else{
				this.signUpClick();
			}
		}
	}
}
</script>