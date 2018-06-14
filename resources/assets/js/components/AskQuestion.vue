<template>
	<div>
		<modal name="question">
			<div class="modal-question">
				<textarea-autosize
					 placeholder="Ask question here..." 
					 :rows="1"
					 :max-height="200"
					 v-model="question"></textarea-autosize>
				<hr>
			<button type="button" class="btn-default" @click="addNew" :disabled="validated">Add Question</button>
			</div>
		</modal>
		<div class="card">
			<div class="card-body">
				<strong><a href="#" @click.prevent="show">Have any question? </a></strong>
			</div>
		</div>
	</div>
	
</template>

<script>
	export default {
		data() {
			return {
				question: '',
			}
		},

		computed: {
			validated() {
				return this.question ? false: true;
			}
		},
		methods: {
			show() {
				this.$modal.show('question');
			},

			hide() {
				this.$modal.hide('question');
			},
			addNew() {
				axios.post('/questions', {
					'question': this.question
				})
				.then(res => {
					this.hide();
					window.location = res.data.redirect;
				});
			},
		}
	}

</script>
<style>

textarea{  
	overflow:hidden;
  	width:500px;
  	font-size:20px;
  	display:block;
  	border: none;
	overflow: auto;
	outline: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
}

</style>