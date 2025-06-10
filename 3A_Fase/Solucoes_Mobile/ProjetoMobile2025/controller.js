// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
import { getFirestore } from "firebase/firestore";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey           : "AIzaSyDdyJlWT2TZ85TGro5uJsOhf4e_bVlwy5g"   ,
  authDomain       : "projetomobile3190-2025.firebaseapp.com"    ,
  projectId        : "projetomobile3190-2025"                    ,
  storageBucket    : "projetomobile3190-2025.firebasestorage.app",
  messagingSenderId: "1019700574834"                             ,
  appId            : "1:1019700574834:web:3cf680ac4eb0e6708720eb",
};

// Initialize Firebase
const app         = initializeApp(firebaseConfig);
export const auth = getAuth(app)                 ;
export const db   = getFirestore(app)            ;