<template>
<div class="container-fluid">
    <div class="row justify-content-center">
		<div class="col">
				<div id="app" class="col" ref="assorteds-window">
				  <div v-if="loading" class="loading">
						  Loading...
				  </div>
                  
                  <div v-for="assorted in assorteds" :key="assorted.id">
                      <p>{{ assorted.title }}</p>
                      <p>{{ assorted.description }}</p>   
                      <div v-html="assorted.body"></div>    
                      <p> <button class="btn btn-primary" v-on:click="handleClick(assorted)">Links</button> </p>
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
            
              assorteds: {},
            }   
        },
        
        
        watch: {
		
	   },

        methods: {
            
        	getAssorteds(){
        		this.loading = true
        		var url = "/assortedlist"
        		
                 axios
                 .get(url)
                 .then(response => (this.assorteds = response.data.assorteds))
 
            },
            
            handleClick(assorted) {
            	  	
            	var url = "/aportal/" + assorted.id
            	
            	this.$router.push(url)
            		
            },
            
            scrollToBottom() {
			this.$nextTick(() => {
				this.$refs['assorteds-window'].scrollTop = this.$refs['assorteds-window'].scrollHeight;
			});
		}
            
        },
        created() {
            this.getAssorteds()
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
