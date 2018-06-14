<template>
	<div>
		<input id="trix" type="hidden" :name="name" :value="value">
  		<trix-editor input="trix" ref="trix" class="trix-content" :placeholder="placeholder"></trix-editor>
	</div>
</template>

<script>
	import Trix from 'trix';
	export default{
		props: ['placeholder', 'shouldRemove', 'name', 'value'],
		mounted() {
			this.$refs.trix.addEventListener('trix-change', e => {
				this.$emit('input', e.target.innerHTML);
			});
			this.$watch('shouldRemove', () => {
				this.$refs.trix.value = '';
			});
			this.$refs.trix.value = this.value;
		}
	}
</script>