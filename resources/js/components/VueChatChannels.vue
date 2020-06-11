<template>
    <div id="app" class="col" ref="channels-window">
        <p v-for="channel in channels"
		:key="channel.id"
		v-text="channel.name"
		class="channel"
		:class="{ 'active': channel.id == activeChannel }"
		@click="setChannel(channel.id)"></p>
    </div>
</template>

<script>
export default {
    props: ['channels', 'activeChannel'],
    
    mounted() {
    this.scrollToBottom();
},

watch: {
    channels() {
        this.scrollToBottom();
    }
},

    
methods: {
   
   setChannel(id) {
        this.$emit('channelChanged', id);
    },
   
scrollToBottom() {
        this.$nextTick(() => {
            this.$refs['channels-window'].scrollTop = this.$refs['channels-window'].scrollHeight;
        });
    }
},
        
}
</script>

<style scoped>

.col {
    overflow-y: auto;
	word-wrap: break-word;
	max-height: 277px;
}

.channel {
    cursor: pointer;
}

.channel.active {
    background: #FF1;
}
</style>


