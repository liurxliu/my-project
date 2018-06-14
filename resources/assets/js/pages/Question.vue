<script>
	import Answers from '../components/Answers.vue';
	import Topics from '../components/Topics.vue';
	import SubscribeButton from '../components/SubscribeButton.vue';

	export default{
		components: {
			'answers': Answers,
			'subscribe-button': SubscribeButton,
			'topics': Topics,
		},

		props:['authCheck', 'data'],

		data() {
			return {
				open: false,
				edit: false,
				updating: false,
				question: this.data.question,
				oldBody: this.data.question
			}
		},
		methods: {
			OpenAnswerBox() {
				if (this.authCheck) {
					this.open = ! this.open;
				}
				this.$modal.show('login');
			},
			remove() {
				axios.delete(document.location.pathname)
					.then(response => {
						document.location.pathname = "/";
						flash('Delete Question!!');
					});
			},
			show() {
				this.$modal.show('login');
			},

			update() {
				this.updating = true;
				this.edit = ! this.edit;
			},

			cancel() {
				this.question = this.oldBody
				this.updating = false;
			}
		},
	}
</script>