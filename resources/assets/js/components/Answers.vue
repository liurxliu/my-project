<template>
<div>
	<new-answer @add="update" v-show="showAnswer"></new-answer>
	<h3 v-text="allAnswer" style="margin-bottom: 30px;"></h3> 
	<div v-for="item in items" :key="item.id">	
		<answer :data="item" @delete="remove" :auth-user="user"></answer>
	</div>
</div>
</template>


<script>
	import Answer from './Answer.vue';
	import NewAnswer from './NewAnswer.vue';
	export default{
		props: ['data', 'authUser', 'answersCount', 'open'],
		components: {
			'answer': Answer,
			'new-answer': NewAnswer
		},
		data() {
			return {
				items: this.data,
				user: this.authUser,
				count: this.answersCount,
				
			}
		},

		computed: {
			allAnswer() {
				if(this.count > 1) {
					return this.count + 'answers';
				}
				return this.count + 'answer';
			},

			showAnswer() {
				if (this.authUser) {
					return this.open;
				}
			}
		},

		methods: {
			remove(index) {
				this.items = this.items.filter(item => {
					return item.id !== index
				});
				this.count--;
			},

			update(data) {
				this.items.push(data);
				this.count++;
				this.$emit('update');
			},

			showAnswerForm() {
				this.showAnswer = ! this.showAnswer;
			}
		}
	}
</script>