<template>
<div>
     <div class="form-group">
     	<wysiwyg v-model="answer" :placeholder="placeholder" :should-remove="completed" :name="name"></wysiwyg>
    </div>
    <button class="btn-default" type="submit" @click="newAnswer">Submit</button>
</div>
</template>

<script>
	
	export default{
		data() {
			return {
				answer: '',
				endpoint: location.href + '/answer',
				placeholder: 'Answer here...',
				completed: false,
				name: 'answer'
			}
		},

		methods: {
			newAnswer() {
				axios.post(this.endpoint, {
					answer: this.answer
				}).
				then(res => {
					this.answer = '';
					this.completed = true;
					document.getElementById('trix').innerHTML = '';
					flash('Add new answer.');
					this.$emit('add', res.data);
				});
			}
		},
	}
</script>