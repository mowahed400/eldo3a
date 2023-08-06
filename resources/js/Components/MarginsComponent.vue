<template>
    <section id="vertical-tabs">
        <div class="row match-height">
            <!-- Vertical Left Tabs start -->
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">الهوامش</h4>
                    </div>
                    <div class="card-body">
                        <div class="nav-vertical">
                            <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                                <li class="nav-item" v-for="(margin,index) in section.margins" :key="margin.id">
                                    <a class="nav-link"
                                       :class="{'active': index === 0}"
                                       :id="'baseVerticalLeft-tab-'+margin.id"
                                       data-toggle="tab"
                                       :aria-controls="'tabVerticalLeft-'+margin.id"
                                       :href="'#tabVerticalLeft'+margin.id"
                                       role="tab" aria-selected="true">{{ margin.name.ar }}</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div v-for="(margin,index) in section.margins" :key="margin.id"
                                     class="tab-pane"
                                     :class="{'active': index === 0}"
                                     :id="'tabVerticalLeft'+margin.id"
                                     role="tabpanel"
                                     :aria-labelledby="'baseVerticalLeft-tab-'+margin.id">

                                    <margins-content-component  :langs="langs"  :content-id="contentId" :margin="margin"></margins-content-component>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Left Tabs ends -->
        </div>
    </section>

</template>

<script>
import MarginContentComponent from "./MarginContentComponent";
export default {
    name: "MarginsComponent",
    components : {
        MarginContentComponent,
    },
    props:{
        section:{
            required:true,
            type: Object
        },
        contentId: {
            required:true,
            type: Number
        },
        langs: {
            required:true,
            type: Array
        }
    },
    mounted() {
        console.table(this.langs)
    }
}
</script>

<style scoped>

</style>
