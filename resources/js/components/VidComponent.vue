<template>
<div class="container-fluid">
    <div class="row justify-content-center">
		<div class="col">
				<div id="app" class="col" ref="vids-window">
				  <div v-if="loading" class="loading">
						  Loading...
				  </div>
                  
                  <div v-for="vid in vids" :key="vid.id">
                      <p>{{ vid.title }}</p>
                      <p>{{ vid.description }}</p>   
                      <div v-html="vid.body"></div>    
                      <p> <button class="btn btn-primary" v-on:click="handleClick(vid)">Links</button> </p>
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
            
              vids: {},
            }   
        },
        
        
        watch: {
		
	   },

        methods: {
            
        	getVids(){
        		this.loading = true
        		var url = "/vidlist"
        		
                 axios
                 .get(url)
                 .then(response => (this.vids = response.data.vids))
 
            },
            
            handleClick(vid) {
            	  	
            	var url = "/vportal/" + vid.id
            	
            	this.$router.push(url)
            		
            },
            
            scrollToBottom() {
			this.$nextTick(() => {
				this.$refs['vids-window'].scrollTop = this.$refs['vids-window'].scrollHeight;
			});
		}
            
        },
        created() {
            this.getVids()
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
