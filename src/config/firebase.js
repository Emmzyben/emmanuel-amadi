import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getDatabase } from "firebase/database";

const firebaseConfig = {
  apiKey: "AIzaSyAxjJPAfFzSOY6pQIms0RFO5UeKfIq_s7Q",
  authDomain: "zippy-pay-9092c.firebaseapp.com",
  databaseURL: "https://zippy-pay-9092c-default-rtdb.firebaseio.com",
  projectId: "zippy-pay-9092c",
  storageBucket: "zippy-pay-9092c.firebasestorage.app",
  messagingSenderId: "606444426400",
  appId: "1:606444426400:web:8596081b9dde14bf0465c5",
  measurementId: "G-3QKZEH01QH"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
export const db = getDatabase(app);
