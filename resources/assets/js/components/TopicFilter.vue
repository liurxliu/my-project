<template>
	<div>
		<modal name="topicFilter" :scrollable="true" height="auto">
			<div class="check-box">
				<div v-for="topic in topics" class="check-item">
					<input type="checkbox" :id="topic.topic" :value="topic.id" v-model="checkTopics">
					<label :for="topic.topic">{{ topic.topic }}</label>
				</div>

				<button style="margin-bottom: 0px; margin-top: 30px;" class="btn-block" @click="addTopics">Select</button>
			</div>

		</modal>

            <p>
            	<li><a href="#" @click.prevent="show">Add your favorite topics</a></li>
            </p>

	</div>
	
</template>

<script>
	export default {
		props: ['topics', 'user'],
		data() {
			return {
				checkTopics: [],
			}
		},
		methods: {
			show() {
				this.$modal.show('topicFilter');
			},
			hide() {
				this.$modal.hide('topicFilter');
			},
			addTopics() {
				axios.post(`/${this.user.name}/topics`, {
					'ids': this.checkTopics
				})
				.then(response => {
					flash('Add new favorite topics.');
					this.hide();
					window.location.href = document.location.href;
				});
			}
		}
	}
</script>