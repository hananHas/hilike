<template>

    <div class="app-inner-layout__wrapper">
        <div class="app-inner-layout__content">
            
            <div class="table-responsive" id="chat_page" style="height: 90vh">
                
                <div class="chat-wrapper" v-if="activeChat" id="messageWindow">
                    <div v-for="(message, index) in messages" :key="'message' + index" :class="{'float-right col-12': iAmSender(message.sender_id)}">
                        <div class="chat-box-wrapper" :class=" {'chat-box-wrapper-right': iAmSender(message.sender_id)}" :style= "[iAmSender(message.sender_id) ? {'float': 'right'} : {}]" >
                            <div v-if="!iAmSender(message.sender_id)">
                                <div class="avatar-icon-wrapper mr-1">
                                    
                                    <div class="avatar-icon avatar-icon-lg rounded">
                                        
                                        <img src="images/avatar_male.jpg" alt="">
                                        
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="chat-box" v-if="!message.is_gift">
                                
                                        {{message.text}}
                                    
                                </div>
                                <div class="chat-box" v-else>
                                
                                        <img style="max-width:350px" :src="message.text" alt="">
                                    
                                </div>

                                <small class="opacity-6">
                                    <i class="fa fa-calendar-alt mr-1"></i>
                                        {{formatDate(new Date(message.created_at.seconds * 1000))}}
                                </small>
                            </div>
                            <div v-if="iAmSender(message.sender_id)">
                                <div class="avatar-icon-wrapper ml-1">
                                    
                                    <div class="avatar-icon avatar-icon-lg rounded">
                                        <img src="images/avatar_male.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
             
        </div>
        <div  v-if="activeChat" class="app-inner-layout__bottom-pane d-block text-center chat-footer" >
            <div class="mb-0 position-relative row form-group">
                <div class="col-sm-12">
                    <div class="input-group mb-1">
                        <input type="text"
                            rows="1"
                            v-model="message"
                            class="form-control"
                            placeholder="New Message"
                            aria-label="New Message"
                            @keydown="inputHandler"
                        >
                        <div class="input-group-append">
                            <button
                            class="btn btn-primary"
                            type="button"
                            :disabled="sending"
                            @click="sendMessage(activeChatId)"
                            >
                            Send
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-inner-layout__sidebar card">
            
            <ul class="nav flex-column" id="users_list" v-for="chat in chats" :key="chat.id">
                <li class="nav-item get_chat" :data-thread="chat.thread_id">
                    <a type="button" tabindex="0" class="dropdown-item" href="#" @click.prevent="selectChat(chat.thread_id)">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <div class="avatar-icon-wrapper">
                                        
                                        <div class="avatar-icon">
                                            
                                            
                                            <img v-if="chat.profile_image != null" :src="chat.profile_image" alt="">
                                            
                                            <img v-else :src=" chat.gender == 'female' ? 'images/avatar_female.jpg' : 'images/avatar_male.jpg'" alt="">
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading ">

                                        <p style="margin-bottom: 0px">{{chat.nickname}} </p>
                                        <div class="mb-2 mr-2 badge badge-pill cat_name">{{chat.category_name}}</div>
                                    </div>
                                </div>
                                <div class="widget-content-right" v-if ="fetchCount(chat) > 0">
                                    <span class="badge badge-pill badge-danger ml-3 mr-0" style="padding: 5px 7px;">{{fetchCount(chat)}}</span>

                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
            
        </div>

    </div>

</template>

<script>
import db from "../fire.js";
import {  collection , query, orderBy , addDoc , doc , Timestamp , onSnapshot , updateDoc ,where} from "firebase/firestore"; 
import moment from 'moment';
export default {
    props: ["chatId", "userId"],
    data() {
        return {
            token: "",
            chats: [],
            messages: [],
            activeChatId: this.chatId,
            message: "",
            sending: false,
            showChatWindow: false,
            chatListBackup: [],
            query: "",
        };
    },

    methods: {
        selectChat(chatId) {
            this.showChatWindow = true;
            this.activeChatId = chatId;
            // console.log(chatId)
        },
        formatDate(date) {
            return moment(String(date)).format('MM/DD/YYYY hh:mm');
        },
        inputHandler(e) {
            if (e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage(this.activeChatId);
            }
        },
        async sendMessage(chatId) {
          // e.preventDefault();
            this.sending = true;
            
            const docRef = await addDoc(collection(db,  "chatThreads/"+chatId+"/messages"), {
                created_at: Timestamp.fromDate(new Date()),
                sender_id: this.userId,
                status: 'seen',
                text: this.message,
                is_gift: false,
                gift_id: 0,
                messagedoc : 'chatThreads/'+chatId+'/messages/'
            });

            await updateDoc(doc(db,  "chatThreads/"+chatId+"/messages", docRef.id), {
                messagedoc: 'chatThreads/'+chatId+'/messages/'+docRef.id
            });

            this.message = "";
            this.sending = false;
           
        },
        iAmSender(sender_id) {
            const str = this.activeChatId;
            return sender_id != str.split('s').pop();
        },
        fetchMessages(chatId)  {
            let vm =  this;
            const messagesRef = collection(db, "chatThreads/"+chatId+"/messages");
            const q = query(messagesRef, orderBy("created_at"));
            const unsubscribe = onSnapshot(q, (querySnapshot) => {
                const messages = [];
                querySnapshot.forEach((doc) => {
                    this.changeMessagesStatus(doc.id);
                    messages.push(doc.data());

                });
                vm.messages = messages;
            });
           
        },

        async changeMessagesStatus(docId) {
            const messagesRef = doc(db, "chatThreads/"+this.activeChatId+"/messages",docId);
            await updateDoc(messagesRef, {
            status: 'seen'
            });
            
        },

        fetchCount(chat)  {
            const chatsq = query(collection(db, "chatThreads/"+chat.id+"/messages"),where('status','!=','seen'));
            
            const chatsReff = onSnapshot(chatsq, (querySnapshot1) => {
                
                chat.count =  querySnapshot1.size;
            });
            return chat.count;
           
        }


    },

    computed: {
        activeChat() {
            let id = this.activeChatId;
            this.fetchMessages(this.activeChatId);
            return this.chats.reduce((prev, chat) => {
                return chat.id === id ? chat : prev;
            }, null);
        }
    },

    beforeMount() {
        
        
        const q = query(collection(db, "chatThreads"));
        const chatsRef = onSnapshot(q, (querySnapshot) => {
            let chats = [];
            querySnapshot.forEach((doc) => {
                if(doc.id.charAt(0) == 's'){
                    let url = "chat_details/"+doc.id;
                    axios.get(url).then(response => {
                        
                    chats.push(response.data.data);
                    var sorted_chats = chats;
                    sorted_chats.sort((a, b)=>
                        
                        Date.parse(b.last_message) - Date.parse(a.last_message)
                    );
                    
                });
                }
                
                
            });
            
            this.chats = chats;
          
        });

       
        
    
    }
};
</script>
