<template>
    <div id="app" class="col" ref="message-window">
        <p v-for="message in messages"
            :key="message.id"
            class="message"
        >
            <span class="datetime">{{ message.created_at }}</span>

            <span class="username"><{{ message.username }}></span>

            <span class="message-text">{{ message.message }}</span>
        </p>
    </div>
</template>

<script>
export default {
    props: ['messages'],
    
    mounted() {
    this.scrollToBottom();
},

watch: {
    messages() {
        this.scrollToBottom();
    }
},

methods: {
    scrollToBottom() {
        this.$nextTick(() => {
            this.$refs['message-window'].scrollTop = this.$refs['message-window'].scrollHeight;
        });
    }
},
        
}
</script>

<style scoped>


.col {
    overflow-y: auto;
    max-height: 333px;
	word-wrap: break-word;
}

.message {
    
}

.datetime {
    color: turquoise;
}

.username {
    color: green;
}
</style>
