<template>
		<div>
        <input type="text"
            class="form-control"
            placeholder="New message. You must be present on the channel to receive."
            v-model="$v.message.$model"
            :class="status($v.message)"
            @keyup.enter.prevent="sendMessage">
           <!-- <pre>{{ $v }}</pre> -->
        </div>
</template>

<script>

import { maxLength } from "vuelidate/lib/validators";
import { helpers } from 'vuelidate/lib/validators'
const alpha = helpers.regex('alpha', /^[a-zA-Z.!?()-;%/+=&$ ]*$/) 
 
export default {
    props: ['activeChannel', 'username'],

    data() {
        return {
            message: '',
        };
    },
    
    validations: {
		message: {
		  maxLength: maxLength(555),
		  alpha,
		  
		},
	},

    methods: {
    
		status(validation) {
			return {
			error: validation.$error,
			dirty: validation.$dirty
			}
		},
    
    sendMessage() {
    
			//if its still pending or an error is returned do not submit
			this.$v.message.$touch();
			if (this.$v.message.$error) return;
        
            let endpoint = `/channels/${this.activeChannel}/messages`;

            let data = {
                username: this.username,
                message: this.message
            };

            axios.post(endpoint, data);

            this.message = '';	
            
        }    
    }
}
</script>

<style scoped>

input {
  border: 1px solid silver;
  border-radius: 4px;
  background: white;
  padding: 5px 10px;
}

.dirty {
  border-color: #5A5;
  background: #EFE;
}

.dirty:focus {
  outline-color: #8E8;
}

.error {
  border-color: red;
  background: #FDD;
}

.error:focus {
  outline-color: #F99;
}


</style>
