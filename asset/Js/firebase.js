// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyAOeV53yH2A2gdH-Y6T_vptLuk5Nw5WWZk",
  authDomain: "pompes-funebres-le-baron.firebaseapp.com",
  projectId: "pompes-funebres-le-baron",
  storageBucket: "pompes-funebres-le-baron.appspot.com",
  messagingSenderId: "819840550902",
  appId: "1:819840550902:web:954bb262290adde177a9d7",
  measurementId: "G-ZEDY3CY33L"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);