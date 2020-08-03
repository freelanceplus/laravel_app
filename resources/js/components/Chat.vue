
<template>
    <div class="row">
        <div class="col-8">
            <div class="card card-default mb-0 pb-0">
                <div class="card-default">Messages</div>
                <div class="card-body p-0">
                    <ul class="list-unstyled" style="height:300px; overflow-y:scroll">
                        <li class="p-2" v-for="(message, index) in messages" :key="index">
                            <strong>myname</strong>
                            {{ message.message }}
                        </li>
                    </ul>
                </div>
                <input @keyup.enter="sendMessage"
                       v-model="newMessage"
                       type="text"
                       name="message"
                       placeholder="Enter your message..."
                       class="form-control">
            </div>
            <span class="text-muted p-0 m-0">user is typing...</span>
        </div>
        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Actie Users</div>
                <div class="card-body">
                    <ul>
                        <li class="py-2">User name</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messages: [],
                newMessage: ''
            }
        },
        created() {
            this.fetchMessages();
            Echo.join('chat')
                .listen('MessageSent', (event) => {
                    this.messages.push("heeeeeeeeeey");
                });
        },
        methods: {
            fetchMessages() {
                axios.get('messages').then(response => {
                    this.messages = response.data;
                })
            },

            sendMessage() {
                this.messages.push({
                   message: this.newMessage
                });
                axios.post('messages', {message: this.newMessage});
                this.newMessage = '';
            }
        }
    }
</script>
