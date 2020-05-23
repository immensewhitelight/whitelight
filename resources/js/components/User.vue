<template>
  <div class="text-center">
    <b-button v-b-tooltip.hover.right="tooltipText"  v-bind:variant="variant"  @click="handler(username)">
  
        {{ username }}
 
    </b-button>  

  </div>
 
</template>

<script>

import EventBus from '../eventBus.js'
export default {

    props: ['username', 'checkbox'],
    
    data() {
	  return {
	     tooltipText: null,
	     variant: null,
	     user: null, 
	     state: false,
	 }		
},

methods: {

	handler(username) {
	
	// reverse state and pass username on button click
	// also called below on create and watch checkbox
	
	if ( username ){
		EventBus.$emit('handleUser', username)
		
		// tooltip and button color change together between two states 
		this.state = !this.state
	 }
	 
        if (this.state == false){
        
        this.variant = 'outline-success'
                
        this.tooltipText = 'block'
        
        return
        
        }
        
        else if (this.state == true){
            
        this.variant = 'outline-danger'
        
        this.tooltipText = 'unblock'
               
        return
        
        }
       
    },
    
},


 created() {
    this.state = this.checkbox
    this.handler()
        
  },

  watch: {
    checkbox() {
		this.state = this.checkbox
        this.handler()
    }
 },

} 

</script>
<style scoped>

.active {
	color: red;
}
</style>
