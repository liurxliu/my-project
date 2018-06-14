<template>
	<div class="dropdown-notify">
		<li v-for="notification in notifications">
			<a :href="notification.data.link" v-text="notification.data.message" @click="markAsRead(notification.id)"></a>
		</li>	  
	</div>
</template>
<script>
	export default {
		props: ['authUser', 'notifications'],

		methods: {
			markAsRead(notificationId) {
				axios.delete('/profile/' + this.authUser.name + '/notifications/' + notificationId);
			}
		}

	}
</script>