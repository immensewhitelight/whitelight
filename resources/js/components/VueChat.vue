<template>

			<div id="app" class="container-fluid">
                    <div class="row">
							<div class="col">
							<input type="checkbox" id="checkbox" v-model="checkbox">
							<label for="checkbox"> block all other users. {{ (checkbox ? "true. you are user: " + this.username : "you are user: " + this.username) }}</label>
							</div>
					</div>
					
					<div class="row">
							<div class="col">
							 <vue-chat-channels :channels="channels"
							:active-channel="activeChannel"
							@channelChanged="onChannelChanged"></vue-chat-channels>
							</div>
						
							<div class="col">
							<vue-chat-participants :participants="participants" :checkbox="checkbox"></vue-chat-participants>
							</div>
					</div>		
							
					<div class="row">		
							<div class="col">
							  <br>	
							  <vue-chat-messages :messages="messages"></vue-chat-messages> 
							</div>
							
				    </div>
				   <br>
				   <br>
					<div class="row">
							<div class="col">
								<vue-chat-new-message :active-channel="activeChannel"
								:username="username"></vue-chat-new-message>
							</div>
				   </div>
				   <br>
			</div>   
       
</template>

<script>

// when user clicks username button in User component, send username over eventbus
import EventBus from '../eventBus.js'
export default {
    
    props: ['channels'],

	data() {
			return {
			
			checkbox: false,
            activeChannel: this.channels[0].id,
            messages: [],
            username: Math.floor(Math.random() * Math.floor(100000)),
            participants: [],
            blocking: [],
            allowing: [],
            
        }	
    },
    
    mounted () {
		EventBus.$on('handleUser', this.addUserToArray);
},
    
    
    methods: {
    
    onChannelChanged(id) {
		this.activeChannel = id;
	  },
	  
	    
	addUserToArray(username) {
	// also removes users from arrays.
	// receive username from EventBus sent from User component upon button click.
	// userbutton clicks in the User component add or remove username from either the blocking array or allowing array,
	// depending on checkbox.
	// if !checkbox, the array being used is blocking[]. first click adds the username to array, next click removes it... 
	// if checkbox, the array being used is allowing[]. first click adds the username to array, next click removes it...
	
	  
		if (!this.checkbox){
		 
			if(!this.blocking.includes(username)){
				this.blocking.push(username);
				
				} else if(this.blocking.includes(username)) {
				
				this.blocking = this.blocking.filter(item => item != username);
				
				}
	
	    } 
	    
	   if (this.checkbox){
	    
			if(!this.allowing.includes(username)){
				this.allowing.push(username);
				
				} else if (this.allowing.includes(username)) {
				
				this.allowing = this.allowing.filter(item => item != username);
				
				}
			}
		
		this.block();	
			
		},

	block(){

		// prevents blocked users messages from being pushed onto messages[].
		// all messages, even from self, are sent to the server before being pushed onto this.messages[].
		// use data.data.username from in received messages to check if username is present in the relevant array. 
			
		// turn off the socket to flush
		this.socket.off();
		
		for (let channel of this.channels) {
			
				if (!this.checkbox){
							
							this.socket.on(`${channel.id}:App\\Events\\MessageSent`, data => {
							
							var self = (this.username == data.data.username);
							var sameChannel =  this.activeChannel == channel.id;  
							var notUsernameInBlocking = (!this.blocking.includes(String(data.data.username)));
							
								if ( (sameChannel && notUsernameInBlocking) || self )   {
											this.messages.push(data.data);
										} 		
							});	
						
				   } 
				
				if (this.checkbox){
				
							this.socket.on(`${channel.id}:App\\Events\\MessageSent`, data => {
							
							var self = (this.username == data.data.username); 
							var sameChannel =  (this.activeChannel == channel.id) ; 
							var usernameInAllowing = this.allowing.includes(String(data.data.username));
			
								if ( (sameChannel && usernameInAllowing ) || self)   {	
											this.messages.push(data.data);
										}			
							
							});
				
				}
			
		}
	
	 // Add new users to user list
    this.socket.on(`user-joined`, data => {
    this.participants = data.participants;
            
    });
  
 
    // Remove users who left from user list
    this.socket.on(`user-left`, data => {
    this.participants = data.participants;

    }); 
	
	}	
		
},
   
 created() {
	
    this.socket = io.connect(`https://somedomain.com:3000?username=${this.username}`, {secure: true});    
    this.block();
 
 },
 
 watch: {
    checkbox() {
		// when checkbox checked clear the arrays.
		// username button state is independent from checkbox but checking checkbox resets username buttons.
		this.blocking = [];
		this.allowing = [];
		
		// blocking must run when a username button clicked and whenever checkbox is checked or unchecked. 
		this.block();
    }
 },
 
 beforeDestroy(){
  EventBus.$off('handleUser', this.addUserToArray);
}
      
}
</script>

<style scoped>

.col {
    
}

</style>

