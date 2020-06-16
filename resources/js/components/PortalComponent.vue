<template>
<div class="container-fluid">
    <div class="row justify-content-center">
		<div class="col">
			<div id="app">
			
			<p>
				<div v-for="artifact in artifacts" :key="artifact.id">
                      <p v-html="artifact" ></p>
                      
			      </div>
			</p>	
                
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {

    	data () {
            return {
              artifacts: null,
            }
        },

        methods: {
            
        	//  retrieve links from db
        	getPost(){
        			
        		var url = "/links/" + this.$route.params.id
	
  				axios.get(url).then(resp => {

  				    this.artifacts = resp.data.post.links;
  				      				     
  				    this.buildUrls(this.artifacts);
  				});

            },
            
            // Convert "links" string into url links
            buildUrls(artifacts){
            	            	
            	//convert the links string into an array by splitting it on: ", " 
            	//links is a string that looks like this: 
            	//	"link1.com:good site, link2.com:awesome, link3.com:great site, link4.com:so super great"
            	var array = artifacts.split(', ');
            	            	
            	//convert each element in that array into an array by splitting it on: ":".
            	// thus array of arrays.
            	var aray = [];
            	var i;
            	for (i = 0; i < array.length; i++){
            		aray[i] = array[i].split(':');
            	}
            	            	
            	// build links from the array of arrays
            	// store in array
            	var links = [];
            	for (i = 0; i < aray.length; i++){
            	
            	var string = `<a href="https://www.${aray[i][0]}" target="popup" onclick="window.open('https://${aray[i][0]}', 'popup', 'width=222,height=222'); return false;"> ${aray[i][1]} </a>`; 
            	
            	//console.log(string);
            	
            	links.push(string);
            	
            	}
            	
            	this.artifacts = links;
            	 
            }
                      
        },
        created() {	
            this.getPost()
        }
    }
</script> 
