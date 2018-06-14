<template>
	<div class="flex">
        <li><a :href="`/topics/${topic.topic}`">{{ topic.topic }}</a></li><i class="material-icons" v-if="editing" style="position: relative;bottom: 5px;" @click="remove">delete_forever</i>
    </div>
</template>
<script>
	export default {
		props: ['topic', 'editing', 'user'],
		methods: {
			remove() {
				axios.delete(`${this.user.name}/topics/${this.topic.topic}`);
				this.$emit('remove', this.topic.id);
			}
		}
	}
</script>