<template>
    <div class="container-fluid">
        <!-- <template> -->
            <b-breadcrumb :items="items"></b-breadcrumb>
        <!-- </template> -->

        <div>
            <b-modal id="modalSuppSite"
            size="lg"
            header-bg-variant="primary"
            header-text-variant="dark"
            no-close-on-backdrop
            no-close-on-esc
            hide-header-close
            hide-footer
            centered >
                <template v-slot:modal-title>
                    <b>Branch Selection </b>
                </template>
                <div class="d-block text-center">
                <branchlist></branchlist>
                </div>
                <!-- <b-button class="mt-3" block @click="$bvModal.hide('modalSuppSite')">Close Me</b-button> -->
            </b-modal>
        </div>

        <div v-if="!detail_supp"></div>
        <div v-else>
            <b-card bg-variant="default">
                <b-card-body >
                    <b-card-title>{{ detail_supp[0].SUPP_SITE_CODE }} - {{detail_supp[0].SUPP_SITE_NAME}}</b-card-title>
                    <b-card-sub-title class="mb-2"><b>NPWP : {{detail_supp[0].PKP_NUM}}</b></b-card-sub-title>
                    <b-card-text>
                        {{ detail_supp[0].ADDR_LINE2 }} {{detail_supp[0].ADDR_LINE3}}
                    </b-card-text>
                </b-card-body>

            </b-card>

            <br>
             <div  class="mx-1">
                <b-button-group>
                    <b-button variant="success" @click="$bvModal.show('modalInputData')">Add Faktur Pajak</b-button>
                </b-button-group>
            </div>
            <br>
            <b-card bg-variant="default" no-body>
                <div>
                    <insertTtflist></insertTtflist>
                </div>
            </b-card>
        </div>


        <div>
        <b-modal id="modalInputData"
            size="xl"
            header-bg-variant="default"
            header-text-variant="dark"
            no-close-on-backdrop
            no-close-on-esc
            hide-header-close
            hide-footer
            centered
        >
            <template v-slot:modal-title>
                <b>Input Faktur Pajak dan BPB</b>
            </template>
            <div class="d-block text-center">
                 <div>
                    <b-card-group deck class="mb-3">
                    <b-card border-variant="dark" header="Faktur Pajak" align="center" style="max-width: 25rem;">
                        <template>
                            <b-container fluid align="left">
                                <b-row no-gutters>
                                    <b-col sm="3">Tipe FP</b-col>
                                    <b-col>
                                        <b-form-select class="mb-3">
                                             <template v-slot:first>
                                                <b-form-select-option value="null" disabled>-- Please select an option --</b-form-select-option>
                                            </template>

                                            <b-form-select-option value="1">Standard</b-form-select-option>
                                            <b-form-select-option value="2">Tanpa Faktur Pajak</b-form-select-option>
                                        </b-form-select>
                                    </b-col>
                                    <div class="w-100"></div>
                                    <b-col sm="3">Nomor FP</b-col>
                                    <b-col>
                                        <b-form-select class="mb-3">
                                             <template v-slot:first>
                                                <b-form-select-option value="null" disabled>-- Please select an option --</b-form-select-option>
                                            </template>

                                            <b-form-select-option value="1">Standard</b-form-select-option>
                                            <b-form-select-option value="2">Tanpa Faktur Pajak</b-form-select-option>
                                        </b-form-select>
                                    </b-col>
                                    <div class="w-100"></div>
                                    <b-col sm="3">Tgl. FP</b-col>
                                    <b-col>
                                        <b-form-select class="mb-3">
                                             <template v-slot:first>
                                                <b-form-select-option value="null" disabled>-- Please select an option --</b-form-select-option>
                                            </template>

                                            <b-form-select-option value="1">Standard</b-form-select-option>
                                            <b-form-select-option value="2">Tanpa Faktur Pajak</b-form-select-option>
                                        </b-form-select>
                                    </b-col>
                                    <div class="w-100"></div>
                                    <b-col sm="3">DPP FP</b-col>
                                    <b-col>
                                        <b-form-select class="mb-3">
                                             <template v-slot:first>
                                                <b-form-select-option value="null" disabled>-- Please select an option --</b-form-select-option>
                                            </template>

                                            <b-form-select-option value="1">Standard</b-form-select-option>
                                            <b-form-select-option value="2">Tanpa Faktur Pajak</b-form-select-option>
                                        </b-form-select>
                                    </b-col>
                                    <div class="w-100"></div>
                                    <b-col sm="3">PPN FP</b-col>
                                    <b-col>
                                        <b-form-select class="mb-3">
                                             <template v-slot:first>
                                                <b-form-select-option value="null" disabled>-- Please select an option --</b-form-select-option>
                                            </template>

                                            <b-form-select-option value="1">Standard</b-form-select-option>
                                            <b-form-select-option value="2">Tanpa Faktur Pajak</b-form-select-option>
                                        </b-form-select>
                                    </b-col>

                                    <div class="w-100"></div>
                                    <b-col sm="6" align="center">
                                        <b-button variant="success" @click="$bvModal.hide('modalInputData')">Save</b-button>
                                    </b-col>
                                    <b-col align="center">
                                        <b-button variant="danger">Cancel</b-button>
                                    </b-col>
                                </b-row>
                            </b-container>
                        </template>
                    </b-card>

                    <b-card border-variant="dark" header="Data BPB" align="center">
                        <div  class="mx-1" align="left">
                            <b-button variant="success" v-b-modal.modalBPBdata size="sm">Tambah Data BPB</b-button>
                            <b-button variant="danger" size="sm">Hapus Data BPB</b-button>
                        </div>

                        <br>
                        <b-card-text>
                            <editorTtflist :selectedBPB=selectedDataBPB></editorTtflist>
                            <!-- <p>
                                {{selectedDataBPB}}
                            </p> -->
                        </b-card-text>
                    </b-card>
                    </b-card-group>
                </div>
            </div>
        </b-modal>
        </div>

        <b-modal
        size="lg"
        header-bg-variant="default"
        header-text-variant="dark"
        no-close-on-backdrop
        no-close-on-esc
        hide-header-close
        hide-footer
        centered
        id="modalBPBdata"
        title="Pilih data BPB">
            <bpbPerSite :site=selectedSite></bpbPerSite>
        </b-modal>

    </div>
</template>
<script>

import { serverBus } from '../../app.js';
import branchlist from '../../components/branch-user-list.vue';
//data grid buat show data sebelum save
import insertTtflist from '../../components/insert-ttf-list.vue';

//data grid buat masukin ttf baru
import editorTtflist from '../../components/editor-ttf-list.vue';

//data grid buat all BPB per site code
import bpbPerSite from '../../components/bpb_per_site.vue';

export default {
// props: {
//   	SITE: {
//       required: true
//     }
// },
data() {
        return {
            //buat breadcrumb
            items: [
                {
                    text: 'Inquiry TTF',
                    active: false,
                    to: { name: 'dashboard' }
                },
                {
                    text: 'Input TTF',
                    active: true
                }
            ] ,// end of breadcrumb
            detail_supp: null,
            selectedSite:null,
            selectedDataBPB:[]
        }
    },
    mounted()
    {
        this.$bvModal.show('modalSuppSite')
    },
     created: function(){
    // Using the server bus
        let self=this;
        serverBus.$on('siteSelected', (siteSelected) => {
        this.selectedSite = siteSelected;
        self.getResults()
        });

        serverBus.$on('onChildClick', (onChildClick) => {
        this.selectedDataBPB = onChildClick;
        });
    },
    methods: {
        onChildClick (value) {
            alert('here');
            this.selectedDataBPB = value
        },
         getResults()
        {
                //alert(this.SITE);
                // this.isBusy = true;
                var suppId = this.$auth.user().supp_id;
                var orgId = this.$auth.user().org_id;
                var siteId = this.selectedSite;
            axios.post('/site_detail',
            {
                    supp_id: suppId,
                    org_id: orgId,
                    site_id: siteId
            })
            .then(
                (res) =>
                {
                    this.detail_supp = res.data.addr_detail;
                    // this.totalRows = res.data.length;
                            // this.isBusy = false;
                },
                () =>
                {
                    this.has_error = true;
                            //  this.isBusy = false;
                }
            );
        }
    },
     components: {
      branchlist,
      insertTtflist,
      editorTtflist,
      bpbPerSite
    }

}
</script>
