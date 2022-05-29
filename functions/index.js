const functions = require("firebase-functions");
const admin = require('firebase-admin');
admin.initializeApp({
    credential: admin.credential.applicationDefault(),
    databaseURL: 'https://hilike-79cc6.firebaseio.com'
  });


exports.sendChatNotifications = functions.firestore.document('chatThreads/{cid}/messages/{did}')
.onCreate(async (messageSnapshot, context)=>{
    const thread_id = context.params.cid;
    const users_chat = thread_id.split("s").length > 1 ? thread_id.split("s") : thread_id.split("admin");
    const type = thread_id.split("s").length > 1 ? 'chat' : 'admin';
    const message = messageSnapshot.data();

    const senderId = message.sender_id;
    // console.log('first_user: ' + users_chat[0]);
    const reciever_id = (senderId == users_chat[1]) ? users_chat[0] : users_chat[1] ;
    
    const user = await admin.firestore().doc(`users/${reciever_id}`).get();
    const user_sender = await admin.firestore().doc(`users/${senderId}`).get();

    const payload = {
      notification: {
        title: user_sender.data() ? user_sender.data().nickName : type == 'chat'? 'Support' : 'Hilike',
        body: message.is_gift ? 'Gift' : message.text,
        sound: 'default',
      },
      data: {
        chat_thread : thread_id,
        nickname: user_sender.data() ? user_sender.data().nickName : '',
        image: user_sender.data() ? user_sender.data().image : '',
        user_id: user_sender.data() ? senderId.toString() : '',
        plan_id: user_sender.data() ? user_sender.data().plan_id.toString() :  type == 'chat'? '5' : '4',
        messagedoc: 'chatThreads/'+thread_id+'/messages/'+context.params.did,

      }
    };

    if(user.data().notification_on == 1){
      await admin.messaging().sendToDevice([user.data().fcmToken], payload);

    }

});

exports.updateMessagesCount = functions.firestore.document('chatThreads/{cid}/messages/{did}')
.onUpdate(async (change, context)=>{
    const thread_id = context.params.cid;
    const users_chat = thread_id.split("s").length > 1 ? thread_id.split("s") : thread_id.split("admin");
    const message = change.after.data();

    const senderId = message.sender_id;
    const reciever_id = (senderId == users_chat[1]) ? users_chat[0] : users_chat[1] ;

    if(message.status == 'delivered'){
        console.log(reciever_id)
        admin.firestore().doc(`users/${reciever_id}`).get().then((userDoc) => {
            userDoc.ref.update({messages_count: admin.firestore.FieldValue.increment(1)});
        });

    }
    else if(message.status == 'seen'){
        admin.firestore().doc(`users/${reciever_id}`).get().then((userDoc) => {
          if(userDoc.data().messages_count != 0){
            userDoc.ref.update({messages_count: admin.firestore.FieldValue.increment(-1)});

          }
        });
    }

});
