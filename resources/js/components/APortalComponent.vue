<template>
<div class="container-fluid">
    <div class="row justify-content-center">
		<div class="col">
			<div id="app" class="col" ref="links-window">
				<div v-if="loading" class="loading">
						  Loading...
				</div>	
                <div v-for="link in links" :key="link.id">  
                   <p v-html="link"> </p>
                </div>
			</div>
        </div>
    </div>
</div>
</template>

var loading

<script>
    export default {

    	data () {
            return {
              links: [],
              polling: null,
            }
        },

        methods: {
            
        	//  retrieve links from db
        	getLinks(){
        	
        		this.loading = true
        		
        		var url = "/alinks/" + this.$route.params.id
	
  				axios.get(url).then(resp => {

  				    this.links = resp.data.assorted.urls;
  		
  				});
            },
            
            scrollToBottom() {
			this.$nextTick(() => {
				this.$refs['links-window'].scrollTop = this.$refs['links-window'].scrollHeight;
			});
		},
		
			pollData () {
					this.polling = setInterval(() => {
							
							
							var url = "/alinks/" + this.$route.params.id
	
							axios.get(url).then(resp => {

								this.links = resp.data.assorted.urls;
					
							});
							
					}, 300000)
					
					this.loading = false;
        }
              
        },
        
        beforeDestroy () {
            clearInterval(this.polling)
		},
        
        created() {	
            this.getLinks();
            this.pollData();

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
