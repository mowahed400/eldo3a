<template>
    <div class="row editor mb-3" >
        <div class="col-md-12 m-1">
            <h3>({{this.lang}})  تعديل المحتوى</h3>
            <button :class="{'btn btn-success ':true}" @click="save()">
                حفظ
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
            <button v-if="redirectTo" class="mx-1" :class="{'btn btn-info ':true}" @click="save(true)">
                حفظ و إعادة التوجيه
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
        </div>
        <div class="col-md-12">
            <div  :id="'editor_'+this.lang"  class="" dir="ltr">
            </div>
        </div>
    </div>
</template>

<script>
import EditorJS from '@editorjs/editorjs';
import Underline from '@editorjs/underline';
import ImageTool from '@editorjs/image';
import Header from '@editorjs/header';
import Paragraph from '@editorjs/paragraph';
import Marker from '@editorjs/marker';
import Quote from '@editorjs/quote';
import FootnotesTune from '@editorjs/footnotes';
import Ayat from '../Plugins/Ayat';
import LinkTool from '@editorjs/link';
import TextVariantTune from '@editorjs/text-variant-tune';
import Table from '@editorjs/table';
import Tooltip from 'editorjs-tooltip';
import ColorPlugin  from 'editorjs-text-color-plugin'
import AlignmentTuneTool from 'editorjs-text-alignment-blocktune';
export default {
    name: "Editor",
    props:{
        object:{
            type:Object,
            required:true
        },
        lang:{
            type:String,
            required:true
        },
        redirectTo:{
            type:String,
        },
        saveRoute:{
            type:String,
            required:true
        }
    },
    data(){
        return {
            editor:null,
            loading:false,
            text: {}
        }
    },
    computed:{
       textFormat(){

           if (this.object.text)
           {
               return  this.object.text[this.lang] ? JSON.parse(this.object.text[this.lang]) : ''
           }

           return ''
       }
    },
    mounted() {
        this.editor = new EditorJS({
            holder: 'editor_'+this.lang,
            placeholder:'أكتب شيئا ...',
            direction:'rtl',
            tools:{
                textVariant: TextVariantTune,
                inlineToolbar: {
                    class:AlignmentTuneTool,
                    config:{
                        default: "right",
                        blocks: {
                            header: 'right',
                            list: 'right'
                        }
                    },
                },
                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+O',
                    config: {
                        quotePlaceholder: '...',
                        captionPlaceholder: 'author',
                    },
                    tunes: ['footnotes'],
                },
                footnotes: {
                    class: FootnotesTune,
                },
                tooltip: {
                    class: Tooltip,
                    config: {
                        location: 'left',
                        highlightColor: '#FFEFD5',
                        underline: true,
                        backgroundColor: '#154360',
                        textColor: '#FDFEFE',
                        holder: 'editor_'+this.lang,
                    }
                },
                underline: Underline,
                marker: Marker,
                table: {
                    class: Table,
                    inlineToolbar: true,
                    config: {
                        rows: 2,
                        cols: 3,
                    },
                },
                Color: {
                    class: ColorPlugin, // if load from CDN, please try: window.ColorPlugin
                    config: {
                        colorCollections: ['#EC7878','#9C27B0','#673AB7','#3F51B5','#0070FF','#03A9F4','#00BCD4','#4CAF50','#8BC34A','#CDDC39', '#FFF'],
                        defaultColor: '#FF1300',
                        type: 'text',
                    }
                },
                header: {
                    class: Header,
                    inlineToolbar:true,
                    //tunes: ['inlineToolbar'],
                    config: {
                        placeholder: 'Enter a header',
                        levels: [2, 3, 4,5,6],
                        defaultLevel: 3
                    }
                },
                paragraph: {
                    class: Paragraph,
                    inlineToolbar: true,
                    tunes: ['textVariant','footnotes'],
                },
                ayat:{
                    class:Ayat,
                    inlineToolbar: true,

                },
                // linkTool: {
                //     class: LinkTool,
                //     config: {
                //         endpoint: '/editor/metadata', // Your backend endpoint for url data fetching
                //     }
                // },
                image: {
                    class: ImageTool,
                    config: {
                        endpoints: {
                            byFile: '/editor/upload/image', // Your backend file uploader endpoint
                            byUrl: '/editor/image/fetchUrl', // Your endpoint that provides uploading by Url
                        },
                        additionalRequestHeaders:{
                            'X-Requested-With':'XMLHttpRequest',
                            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content
                        },
                    },
                },

            },
            data:this.textFormat
        })
    },
    methods:{

        save(redirect = false){

            this.editor.save()
                .then((outputData) => {
                    this.loading = true;
                    this.text[this.lang] = JSON.stringify(outputData)
                        axios.put(this.saveRoute,{
                        text:this.text,
                    }).then(({data}) => {
                        this.$moshaToast({
                            title: 'Success',
                            description: data.message,
                        },{
                            type: 'success',
                            showIcon: 'true',
                        })
                            if (redirect)
                            {
                                window.location = this.redirectTo
                            }
                    }).catch(err => {
                        this.$moshaToast({
                            title: 'Error',
                            description: err.response.data.message,
                        },{
                            type: 'danger',
                            showIcon: 'true',
                        })
                    }).finally(() => {this.loading = false;});
                }).catch((error) => {
                console.log('Saving failed: ', error)
            })

        }
    }
}
</script>

<style >
.editor {
    box-shadow: 5px -3px 23px 3px rgba(148,146,146,0.75);
    -webkit-box-shadow: 5px -3px 23px 3px rgba(148,146,146,0.75);
    -moz-box-shadow: 5px -3px 23px 3px rgba(148,146,146,0.75);
    border-radius: 10px
}

.ce-block__content,
.ce-toolbar__content {
    max-width: 70%;
}

/*.codex-editor__redactor{*/
/*    padding-bottom: 10px !important;*/
/*}*/

#editor-js {
    width: 100% !important;
}

.dark-layout .ce-inline-tool{
    color : #B4B7BD;
    background-color : #161D31;
}

.dark-layout .ce-inline-tool--active{
    color : #B4B7BD;
    background-color : #161D31;
}

.dark-layout .ce-toolbox__button{
    color : #B4B7BD;
    background-color : #161D31;
}

.dark-layout .ce-toolbox__button{
    color : #B4B7BD;
    background-color : #161D31;
}

.dark-layout .cdx-settings-button--active{
    color : #B4B7BD;
    background-color : #161D31;
}

.dark-layout .ce-toolbar__settings-btn{
    color : #B4B7BD;
    background-color : #161D31;
}
.dark-layout .ce-toolbar__plus{
    color : #B4B7BD;
    background-color : #161D31;
}

.dark-layout .ce-toolbar__actions-buttons{
    color : #B4B7BD;
    background-color : #161D31;
}



</style>
