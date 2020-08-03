<template>
    <div class="panel-block field">
        <div class="control">
            <input type="text" class="input" placeholder="enter message" v-on:keyup.enter="sendChat" v-model="chat">
        </div>
        <div class="control auto-width">
            <input type="button" class="button" value="Send" v-on:click="sendChat">
        </div>
     </div>
</template>

<script>
    export default {
        props: ['buyer_id', 'chats', 'sender', 'seller_id'],
        data() {
            return {
                chat: ''
            }
        },
        methods: {
            sendChat: function (e) {
                if(this.chat != '') {
                    var data = {
                        message: this.chat,
                        buyer_id: this.buyer_id,
                        seller_id: this.seller_id,
                        sender: this.sender
                    }
                    this.chat = '';
                    axios.post('/chat/sendChat', data).then((response) => {
                        this.chats.push(data)
                    })
                }
            }
        }
    }
</script>

<style scoped>
    .panel-block {
        flex-direction: row;
        width: 100%;
        border: none;
        padding: 0;
    }
    .input-mesage {
        width: 100%;
    }
    input {
        border-radius: 0;
    }
    .input{
        width: 100%;
        padding: 5px;
        border: 2px solid black;
    }
    .auto-width {
        width: auto;
    }
</style>
