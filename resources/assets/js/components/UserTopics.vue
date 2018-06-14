<template>
	<div>
		<div v-for="topic in allTopics">
			<user-topic :topic="topic" :editing="editing" :user="user" @remove="remove"></user-topic>
		</div>
	</div>
</template>

<script>
	import UserTopic from './UserTopic.vue';
	export default {
		components: {
			'user-topic': UserTopic
		},
		props: ['topics', 'editing', 'user'],
		data() {
			return {
				allTopics: this.topics,
			}
		},
		methods: {
			remove(id) {
				this.allTopics = this.allTopics.filter(topic => {
					return topic.id != id;
				});
			}
		},
	}
</script>