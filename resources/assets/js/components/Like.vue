<template>
	<button class="question-btn" @click="like">
		<i class="material-icons">
			thumb_up_alt
		</i>
		<span v-text="likeCount" style="position: relative; bottom: 5px;"></span>
	</button>
</template>
<script>
	export default{
		props: ['answer', 'authUser'],
		data() {
			return {
				like_count: this.answer.likes_count,
				isLiked: this.answer.isLiked,
			}
		},
		methods: {
			like() {
				if (this.authUser) {
					if(this.isLiked) {
						axios.delete('/answers/' + this.answer.id + '/likes');
						this.like_count--;
						this.isLiked = false;
					} else {
						axios.post('/answers/' + this.answer.id + '/likes');
						this.like_count++;
						this.isLiked = true;
					}
				} else {
					this.$modal.show('login')
				}
			}
		},

		computed: {
			likeCount() {
				return this.like_count ? this.like_count : 0;
			}
		}
	}
	
</script>