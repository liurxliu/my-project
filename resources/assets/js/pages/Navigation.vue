<script>
	import Notification from '../components/Notification.vue';
	import Login from './Login.vue';
	export default {
		props:['authUser'],
		components: {
			'notification': Notification,
			'login': Login
		},
		data() {
			return {
				notify: false,
				notifications: [],
				active: false
			}
		},

		methods: {
			showNotification() {
				this.notify = ! this.notify;
			},
			show() {
				this.$modal.show('login')
			}
		},

		created() {
			if (this.authUser) {
				axios.get(`/profile/{this.authUser.name}/notifications`)
				.then(res => {
					this.notifications = res.data;
				});
			}
			
		}
	}
</script>