<template>
    <div class="card-footer text-muted" >
        <h3>Upload Voice file ({{ this.type }})</h3>
        <input type="file" name="voice" :id="this.fileName" >
        <template v-if="typeCheck">
            <audio controls :src="getUrl"  preload="none">
                Your browser does not support the audio element.
            </audio>
            <br>
            <button class="btn btn-sm btn-danger" @click="deleteVoice()">
                <i class="fas fa-trash"></i>
            </button>
        </template>

    </div>

</template>

<script>
import * as FilePond from 'filepond';

export default {
    name: "UploadFile",
    props:{
        object:{
            type:Object,
            required:true
        },
        postRoute:{
            type:String,
            required:true
        },
        deleteRoute:{
            type:String,
            required:true
        },
        type:{
            type:String,
            default:'en'
        }
    },
    data(){
        return {
            pond:null,
            content: this.object
        }
    },
    computed:{
        fileName(){
            return 'voice_'+this.type;
        },
        typeCheck(){
            return this.content.voice && this.content.voice[this.type]
        },
        getUrl(){
            return this.content.voice_url[this.type]
        }
    },
    mounted() {
        let that = this;
        this.pond = FilePond.create(document.getElementById(this.fileName),{
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    // fieldName is the name of the input field
                    // file is the actual file object to send
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);

                    const request = new XMLHttpRequest();

                    request.open('POST', this.postRoute);
                    request.setRequestHeader('X-CSRF-TOKEN',document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
                    request.setRequestHeader('X-Requested-With','XMLHttpRequest')

                    // Should call the progress method to update the progress to 100% before calling load
                    // Setting computable to false switches the loading indicator to infinite mode
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };

                    // Should call the load method when done and pass the returned server file id
                    // this server file id is then used later on when reverting or restoring a file
                    // so your server knows which file to return without exposing that info to the client
                    request.onload = function () {
                        if (request.status >= 200 && request.status < 300) {
                            // the load method accepts either a string (id) or an object
                            that.content = JSON.parse(request.response).content
                            load(request.responseText);
                            that.$moshaToast({
                                title: 'Success',
                                description: "upload succeeded",
                            },{
                                type: 'success',
                                showIcon: 'true',
                            })
                        } else {
                            // Can call the error method if something is wrong, should exit after
                            let errorMessage = JSON.parse(request.response).message
                            that.$moshaToast({
                                title: 'Error',
                                description: errorMessage,
                            },{
                                type: 'danger',
                                showIcon: 'true',
                            })
                            error(errorMessage);
                        }
                    };

                    request.send(formData);

                    // Should expose an abort method so the request can be cancelled
                    return {
                        abort: () => {
                            // This function is entered if the user has tapped the cancel button
                            request.abort();

                            // Let FilePond know the request has been cancelled
                            abort();
                        },
                    };
                },

            },
        })
    },
    methods:{
        deleteVoice(){
            confirm('Are you sur') ?  axios.delete(this.deleteRoute).then(({data}) => {
                this.content = data.content;
            }).catch(err => {}) : ""

        }
    }

}
</script>

<style scoped>

</style>
