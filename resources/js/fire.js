// import firebase from "firebase/app";
// import "firebase/database";

// var config = {
//     apiKey: "AIzaSyC7OqtF6txkRSmb6JHv7RwdFaO2VpyjGHE",
//     authDomain: "hilike-79cc6.firebaseapp.com",
//     databaseURL: "https://hilike-79cc6.firebaseio.com",
//     projectId: "hilike-79cc6",
//     storageBucket: "hilike-79cc6.appspot.com",
// };

// var fire = firebase.initializeApp(config);
// export default fire;

// Initialize Cloud Firestore through Firebase
import { initializeApp } from "firebase/app"
import { getFirestore } from "firebase/firestore"
const firebaseApp = initializeApp({
  apiKey: 'AIzaSyC7OqtF6txkRSmb6JHv7RwdFaO2VpyjGHE',
  authDomain: 'hilike-79cc6.firebaseapp.com',
  projectId: 'hilike-79cc6'
});

const db = getFirestore();
export default db;
