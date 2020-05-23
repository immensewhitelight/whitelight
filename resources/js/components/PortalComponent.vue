<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
             <!--   <div class="card-header">Links:</div> -->
                
                <div class="card-body">
			
				<span v-html="post"></span></p>
				
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {

    	data () {
            return {
              post: null,
            }
        },

        methods: {
            
        	//  retrieve links from db
        	getPost(){
        			
        		var url = "/links/" + this.$route.params.id
	
  				axios.get(url).then(resp => {

  				    this.post = resp.data.post.links;
  				      				     
  				    this.buildUrls(this.post);
  				});

            },
            
            // Convert "links" string into url links
            buildUrls(post){
            	            	
            	//convert the links string into an array by splitting it on: ", " 
            	//links is a string that looks like this: 
            	//	"link1.com:good site, link2.com:awesome, link3.com:great site, link4.com:so super great"
            	var array = post.split(', ');
            	            	
            	//convert each element in that array into an array by splitting it on: ":".
            	var aray = [];
            	var i;
            	for (i = 0; i < array.length; i++){
            		aray[i] = array[i].split(':');
            	}
            	            	
            	//convert the array of arrays into a string of url links
            	var links = '| ';
            	for (i = 0; i < aray.length; i++){
            		links += '<a href="https://' + aray[i][0] + '">'  + aray[i][1] + '</a> ' + ' | ';
            	}
            	
            	this.post = links;
            	 
            }
                      
        },
        created() {	
            this.getPost()
        }
    }
</script> 
