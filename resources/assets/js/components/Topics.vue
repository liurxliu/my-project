<template>
	<div>
		<modal name="topic">
			<div class="topic-modal">
		      <h3>New Topic</h3>
		      <input class="topic-input" type="text"  
		      		 v-model="topic">

		      <br>
		      <button class="btn-default" 
		      		  @click="addTopic">add
		      </button>
		      <hr>
		    </div>
		</modal>
		<p style="margin-bottom: 0;">
			<span class="badge" v-for="item in topics"><a :href="`/topics/${item.topic}`">{{ item.topic }}</a></span>
			<span class="badge" @click="show">Add+</span>
		</p>
	</div>
</template>

<script>
	export default {
		props: ['data', 'authCheck'],
		data() {
			return {
				topics: this.data,
				topic: ''
			}
		},
		methods: {
			exists() {
				return this.topics.find(element => {
					return element.topic == this.topic;
				});
			},
			hide() {
				this.$modal.hide('topic')
			},
			show() {
				if (this.authCheck) {
					this.$modal.show('topic');
				} else {
					this.$modal.show('login');
				}
			},
			addTopic() {
				if(!this.exists()) {
					axios.post(`${location.pathname}/topics`, {
						topic: this.topic
					})
					.then(res => {
						this.hide();
						this.topics.push({
							topic: this.topic
						});
						this.topic = '';
						flash('Add new topic!')
					});
				} else {
					this.hide();
					this.topic = '';
					flash("This topic has already been created!", 'error');
				}
				
			}

		}
	}
	
</script>