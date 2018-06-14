
<script>
	import TopicFilter from '../components/TopicFilter.vue';
	import UserTopics from '../components/UserTopics.vue';

	export default {
		data() {
			return {
				editing: false
			}
		},
		components: {
			'topic-filter': TopicFilter,
			'user-topics': UserTopics,
		},
		computed: {
			currentPath() {
				return document.location.pathname + document.location.search;
			}
		},
		methods: {
			editTopic() {
				this.editing = ! this.editing;
			},
			show() {
				this.$modal.show('login');
			}
		}
	}
</script>