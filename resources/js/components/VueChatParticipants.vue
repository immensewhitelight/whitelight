<template>
    <div id="app" class="col" ref="participants-window">
		<div>
			<user 
			v-for="(username, index) in participants"
			v-bind:username="username"
			v-bind:index="index"
			v-bind:key="`user-${index}`"
			v-bind:checkbox="checkbox"
			> </user>
		</div>     
    </div>
</template>

<script>
export default {
    props: ['participants', 'checkbox'],
    
    data() {
	  return {
	     
	 }		
},
    
    mounted() {
    this.scrollToBottom();
},

watch: {
    participants() {
        this.scrollToBottom();
    }
},

methods: {
    scrollToBottom() {
        this.$nextTick(() => {
            this.$refs['participants-window'].scrollTop = this.$refs['participants-window'].scrollHeight;
        });
    }
},
} 

</script>

<style scoped>

.col {
    overflow-y: auto;
	word-wrap: break-word;
	max-height: 111px;
}
</style>

