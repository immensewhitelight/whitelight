<template>
<div class="container-fluid">
    <div class="row justify-content-center">
		<div class="col">
				<div id="app" class="col" ref="videos-window">
				  <div v-if="loading" class="loading">
						  Loading...
				  </div>
                  
                  <div v-for="video in videos" :key="video.id">
                      <p>{{ video.title }}</p>
                      <p>{{ video.description }}</p>   
                      <div v-html="video.body"></div>    
                      <p> <button class="btn btn-primary" v-on:click="handleClick(video)">Links</button> </p>
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
            
              videos: {},
            }   
        },
        
        
        watch: {
		
	   },

        methods: {
            
        	getVideos(){
        		this.loading = true
        		var url = "/videolist"
        		
                 axios
                 .get(url)
                 .then(response => (this.videos = response.data.videos))
 
            },
            
            handleClick(video) {
            	  	
            	var url = "/vportal/" + video.id
            	
            	this.$router.push(url)
            		
            },
            
            scrollToBottom() {
			this.$nextTick(() => {
				this.$refs['videos-window'].scrollTop = this.$refs['videos-window'].scrollHeight;
			});
		}
            
        },
        created() {
            this.getVideos()
        },
        
        
        mounted() {
		this.loading = false
	  }

        
    }
</script> 

<style scoped>
.col {
    overflow-y: auto;
    max-height: 188px;
	word-wrap: break-word;
}
</style>
