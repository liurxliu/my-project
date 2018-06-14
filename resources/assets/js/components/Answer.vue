<template>
    <div>
    	<img class="home-image" :src="data.owner.avatar_path">
    	<div class="flex">
	        <p class="image-content" :id="'answer-' + answerId">
	            <span><a :href="`/profile/${data.owner.name}`">{{ data.owner.name }}</a></span><br>
	            <font color="#9d9d9d">{{ ago(data.created_at) }}</font>
	        </p>
	        <div class="dropdown">
	        	<button v-if="canUpdate" @click="active = ! active"><i class="material-icons">format_list_bulleted</i></button>
	        	<div class="dropdown-content" v-show="active">
                    <ul>
                        <li @click="edit" class="edit">Edit</li>
                        <li @click="deleteAnswer" class="delete">Delete</li>
                    </ul>
                </div>
	        </div>
	    </div>
            <div v-if="editing">
            	<form @submit.prevent="update">
            		<wysiwyg v-model="body"></wysiwyg>
	                <br>
	                <button class="btn-default">Update</button>
	                <button class="btn-default" @click="cancel" type="button">Cancel</button>
	            </form>
            </div>
            <div class="form-group trix-content" v-else v-html="body"></div>
            <br>
            <like :answer="data" :auth-user="authUser"></like>
            <br>
            <hr>
    </div>
</template>

<script>
import Like from './Like.vue';
	export default{
		components: {
			'like': Like
		},
		props: ['data', 'authUser'],
		data() {
			return {
				answerId: this.data.id,
				editing: false,
				body: this.data.answer,
				active: false
			}
		},
		computed: {
			canUpdate() {
				if(this.authUser) {
					if(this.authUser.id == this.data.owner.id) {
						return true;
					}
				}
				return false;
			}
		},
		methods: {
			update() {
				axios.patch('/answers/' + this.data.id, {
					'answer': this.body
				})
				.then(res => {
					this.editing = false;
					flash('Updated');
				});
			},
			deleteAnswer() {
				axios.delete('/answers/' + this.data.id);
				this.$emit('delete', this.data.id);
				flash('Delete Answer.');
			},

			edit() {
				this.oldBody = this.body;
				this.editing = true;
				this.active = false;
			},

			cancel() {
				this.editing = false;
				this.body = this.oldBody;
			},

			ago(time) {
				return moment(time).fromNow();
			}
		}
	}
</script>