<template>
	<div class="profile">
		<img :src="avatar" width="150px">
		<form method="POST" enctype="multipart/form-data" v-show="authCheck">
			<br>
			<div class="form-group d-flex">
				<button class="btn-default" @click.prevent="upload">Upload</button>
				<input class="form-control-file" type="file" name="avatar" accept="image/*" @change="onChange">
			</div>
		</form>
	</div>
</template>

<script>
	export default{
		props: ['profileUser', 'authCheck'],

		data() {
			return {
				avatar: this.profileUser.avatar_path,
				file: ''
			}
		},

		methods: {
			onChange(e) {
				if(! e.target.files.length) return;
				this.file = e.target.files[0];
				let reader = new FileReader();
				reader.readAsDataURL(this.file);
				reader.onload = e => {
					this.avatar = e.target.result;
				}
			},
			upload() {
				let data = new FormData();
				data.append('avatar', this.file);
				axios.post(`/api/users/this.profileUser.id/avatar`, data)
					 .then(res => {
						flash('Updated avatar!');
						window.location.replace(window.location.pathname)
					 });
			}
		}
	}
</script>