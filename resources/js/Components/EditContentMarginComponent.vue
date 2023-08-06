<template>
    <div class="modal-size-lg d-inline-block">

        <!-- Modal -->
        <div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel17">Edit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" ref="closeModel">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form form-horizontal">
                            <div class="row">

                                <div class="col-12 mb-2" v-for="(config, lang) in langs" :key="lang">
                                    <label for="name">
                                        Name
                                        <span v-if="lang === 'ar'" class="text-danger">*</span>
                                        ({{lang}})
                                    </label>
                                    <input type="text"
                                           :dir="config.dir"
                                           class="form-control"
                                           :id="'name-'+lang"
                                           v-model="item.name[lang]"
                                           placeholder="Name"
                                           :required="lang === 'ar'" />

                                </div>
                                <div class="col-12 mb-2" v-for="(config, lang) in langs" :key="lang">
                                    <label for="description">
                                        Description
                                        ({{lang}})
                                    </label>
                                    <textarea
                                        rows="4"
                                        :dir="config.dir"
                                        class="form-control"
                                        :id="'description-'+lang"
                                        v-model="item.description[lang]"
                                        placeholder="..."
                                    ></textarea>


                                </div>

                                <div class="col-12 ">

                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="updateItem()" :disabled="isDisabled"
                                class="btn  btn-primary mr-1" :class="{disabled : isDisabled}">Save</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditContentMarginComponent",
    props:{
        margin:{
            Type:Object,
            default:() => {}
        },
        langs:{
            required:true,
            type:Array,
        },
    },
    data(){
        return {
            item: this.margin
        }
    },
    computed:{
        isDisabled(){
            return this.item.name.ar.length === 0
        }
    },
    methods:{
        close(withRefresh = false){
            this.$refs.closeModel.click()
            this.$emit('edit-modal-closed',withRefresh)
        },
        updateItem(){
            axios.put(`/admin/content-margins/${this.margin.id}`,this.item)  .then(({data}) => {
                this.$moshaToast({
                    title: 'Success',
                    description: data.message,
                },{
                    type: 'success',
                    showIcon: 'true',
                })
                this.close(true);
            }).catch(err => {
                this.$moshaToast({
                    title: 'Error',
                    description: err.response.data.message,
                },{
                    type: 'danger',
                    showIcon: 'true',
                })
            })
        }
    }
}
</script>

<style scoped>

</style>
