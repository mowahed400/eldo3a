<template>
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">اضافة</h4>
                    </div>
                    <div class="card-body">
                        <form class="form form-horizontal">
                            <div class="row">

                                <div class="col-12 mb-2" v-for="(config, lang) in langs" :key="lang">
                                    <label for="name">
                                        الاسم
                                        <span v-if="lang === 'ar'" class="text-danger">*</span>
                                        ({{lang}})
                                    </label>
                                    <input type="text"
                                           :dir="config.dir"
                                           class="form-control"
                                           :id="'name-'+lang"
                                           v-model="item.name[lang]"
                                           placeholder="..."
                                           :required="lang === 'ar'" />

                                </div>
                                <div class="col-12 mb-2" v-for="(config, lang) in langs" :key="lang">
                                    <label for="description">
                                        الوصف
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
                                    <button type="button" @click="add()" :disabled="isDisabled"
                                            class="btn  btn-primary mr-1" :class="{disabled : isDisabled}">حفظ</button>
                                    <button type="button" @click="window.location = `/admin/contents/${contentId}`"
                                            class="btn btn-outline-secondary">إلغاء
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <div class="col-12">
        <h3>{{ margin.name['ar'] }}</h3>
        <edit-content-margin-component @edit-modal-closed="EditModalClosed()" v-if="editedItem" :langs="langs" :margin="editedItem"></edit-content-margin-component>
        <div class="card" v-for="mg in margins" :id="'table-'+margin.id">
            <div class="card-header">
                <div class="header-actions">
                    <button type="button" class="btn btn-danger m-1" @click="deleteItem(mg)">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" data-toggle="modal" data-target="#large" class="btn btn-warning m-1" @click="editItem(mg)">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%">
                            الاسم
                        </th>
                        <td style="width: 70%">
                            <div class="collapse-border">
                                <div class="card" v-for="(config, lang) in langs" :key="lang">
                                    <div :id="`headingCollapse-name-${mg.id}-${lang}`" class="card-header" aria-expanded="true"
                                         data-toggle="collapse" role="button"
                                         :data-target="`#collapse-name-${mg.id}-${lang}`"
                                        :aria-controls="`collapse-name-${mg.id}-${lang}`">
                                        <span class="lead collapse-title"> {{lang}} </span>
                                    </div>
                                    <div :id="`collapse-name-${mg.id}-${lang}`" role="tabpanel" :aria-labelledby="`headingCollapse-name-${mg.id}-${lang}`" class="collapse show">
                                        <div class="card-body">
                                            {{mg.name[lang]}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 30%">
                            الوصف
                        </th>
                        <td style="width: 70%">
                            <div class="collapse-border">
                                <div class="card" v-for="(config, lang) in langs" :key="lang">
                                    <div :id="`headingCollapse-description-${mg.id}-${lang}`" class="card-header"
                                         data-toggle="collapse" role="button"
                                         :data-target="`#collapse-description-${mg.id}-${lang}`"
                                         aria-expanded="true" :aria-controls="`collapse-description-${mg.id}-${lang}`">
                                        <span class="lead collapse-title"> {{lang}} </span>
                                    </div>
                                    <div :id="`collapse-description-${mg.id}-${lang}`" role="tabpanel" :aria-labelledby="`headingCollapse-description-${mg.id}-${lang}`" class="collapse show">
                                        <div class="card-body">
                                            {{mg.description[lang]}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                </table>
            </div>

        </div>
       <div class="card card-bordered"  v-if="margins.length === 0">
           <div class="card-body">
               <h4 class="text-center">
                   لا توجد بيانات متوفرة في الجدول
               </h4>
           </div>
       </div>
    </div>
</template>

<script>
import EditContentMarginComponent from "./EditContentMarginComponent";
export default {
    name: "MarginContentComponent",
    components: {EditContentMarginComponent},
    props:{
        margin:{
            required:true,
            type: Object
        },
        contentId: {
            required:true,
            type: Number
        },
        langs:{
            required:true,
            type:Array,
        },

    },
    data(){
        return {
            margins:[],
            item:{
                name:{
                    ar: '',
                },
                description:{
                    ar:''
                }
            },
            editedItem:null
        }
    },
    computed:{
        isDisabled(){
            return this.item.name.ar.length === 0
        }
    },
    mounted() {
        this.getMargins();
        $(`table-${this.margin.id}`).DataTable( {
            "paging":   false,
            "ordering": false,
            "info":     false,
            'searching' : false
        } )
    },
    methods:{
        getMargins(){
            axios.get(`/admin/contents/${this.contentId}/margins/${this.margin.id}`)
                .then(({data}) => {
                    this.margins = data.margins.data
                }).catch(err => console.error())
        },
        add(){
            axios.post(`/admin/contents/${this.contentId}/margins/${this.margin.id}`,this.item)
                .then(({data}) => {
                    this.getMargins();
                    this.resetDefault();
                    this.$moshaToast({
                        title: 'Success',
                        description: data.message,
                    },{
                        type: 'success',
                        showIcon: 'true',
                    })
                }).catch(err => {
                this.$moshaToast({
                    title: 'Error',
                    description: err.response.data.message,
                },{
                    type: 'danger',
                    showIcon: 'true',
                })
            }).finally(() => {});
        },
        deleteItem(margin)
        {
            Swal.fire({
                title: 'هل انت متاكد ؟',
                text:'لن تكون قادرا على التراجع عن هذا!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم',
                cancelButtonText: 'الغاء'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/admin/content-margins/${margin.id}`)
                        .then(({data}) => {
                            this.getMargins();
                            this.$moshaToast({
                                title: 'Success',
                                description: data.message,
                            },{
                                type: 'success',
                                showIcon: 'true',
                            })
                        }).catch(err => {
                        this.$moshaToast({
                            title: 'Error',
                            description: err.response.data.message,
                        },{
                            type: 'danger',
                            showIcon: 'true',
                        })
                    }).finally(() => {});
                }
            });

        },
        editItem(margin)
        {
            this.editedItem = margin;
        },
        EditModalClosed(withRefresh){
            this.editedItem = null

            if (withRefresh)
            {
                this.getMargins()
            }

        },
        resetDefault()
        {
            this.item = {
                name:{
                    ar: '',
                },
                description:{
                    'ar':null
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
