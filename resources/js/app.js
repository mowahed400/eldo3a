require('./bootstrap');
import moshaToast  from 'mosha-vue-toastify'
import    'mosha-vue-toastify/dist/style.css'
import { createApp } from 'vue'
import UploadFile from "./Components/UploadFile";
import Editor from "./Components/Editor";
import MarginsComponent from "./Components/MarginsComponent";
import MarginContentComponent from "./Components/MarginContentComponent";


const app = createApp({})
app.use(moshaToast)
app.component('upload-file', UploadFile)
app.component('editor', Editor)
app.component('margins-component', MarginsComponent)
app.component('margins-content-component', MarginContentComponent)

app.mount('#app')
