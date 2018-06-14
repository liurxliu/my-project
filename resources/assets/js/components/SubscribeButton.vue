<template>
	<div>
		<button class="question-btn" @click="subscribe">
			<i class="material-icons">rss_feed</i>{{ isSubscribed }}
		</button>
	</div>
</template>

<script>
	export default {
		props: ['active', 'authCheck'],
		data() {
			return {
				subscribed: this.active,
			}
		},

		computed: {
			isSubscribed() {
				return this.subscribed ? 'Unfollow': 'Follow';
			}
		},

		methods: {
			subscribe() {
				if (this.authCheck) {
					axios[this.subscribed ? 'delete': 'post'](location.pathname + '/subscribe');
					this.subscribed = ! this.subscribed;
				} else {
					this.$modal.show('login');
				}
				
			}
		}
	}
</script>