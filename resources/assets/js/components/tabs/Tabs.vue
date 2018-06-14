<template>
	<div>
		<ul class="nav">
		  <li class="nav-item" v-for="tab in tabs">
		    <a class="nav-link" 
		       :href="tab.href" 
		       :class="{' active': tab.isActive}" 
		       @click="selectTab(tab)">
		    {{ tab.name }}
			</a>
		  </li>
		</ul>
		<div class="tabs-details">
			<slot></slot>
		</div>
	</div>
	
</template>

<script>
	export default{
		data(){
			return {
				tabs: {},
			}
		},
		created() {
			this.tabs = this.$children;
		},
		methods: {
			selectTab(selectedTab) {
				this.tabs.forEach(tab => {
					tab.isActive = (tab.name == selectedTab.name);
				})
			}
		}
	}
</script>