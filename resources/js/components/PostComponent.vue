<template>
<div class="container-fluid">
    <div class="row justify-content-center">
		<div class="col">
				<div id="app" class="col" ref="posts-window">
				  <div v-if="loading" class="loading">
						  Loading...
				  </div>
                  
                  <div v-for="post in posts" :key="post.id">
                      <p>{{ post.title }}</p>
                      <p>{{ post.description }}</p>   
                      <div v-html="post.body"></div>    
                      <p> <button class="btn btn-primary" v-on:click="handleClick(post)">Links</button> </p>
			      </div>
			   </div>
        </div>
    </div>
</div>
</template>
<script>

var loading
    export default {

    	data () {
            return {
            
              posts: {},
            }   
        },
        
        
        watch: {
		
	   },

        methods: {
            
        	getPosts(){
        		this.loading = true
        		var url = "/postlist"
        		
                 axios
                 .get(url)
                 .then(response => (this.posts = response.data.posts))
 
            },
            
            handleClick(post) {
            	
            	var url = "/portal/" + post.id
            	
            	this.$router.push(url)
            },
            
            scrollToBottom() {
			this.$nextTick(() => {
				this.$refs['posts-window'].scrollTop = this.$refs['posts-window'].scrollHeight;
			});
		}
            
        },
        created() {
            this.getPosts()
        },
        
        
        mounted() {
		this.loading = false
	  }

        
    }
</script> 

<style scoped>
.col {
    overflow-y: auto;
    max-height: 250px;
	word-wrap: break-word;
}
</style>
