<template>
    <div>
        <b-table
        responsive
        ordered
        ref="branchTable"
        small
        select-mode="single"
        head-variant="dark"
        selectable
        selected-variant="warning"
         @row-selected="onRowSelected"
        :items="branchlist" :fields="fields" :busy="isBusy" show-empty align="center" valign="middle"  >
            <!-- <template v-slot:head(selected)="row">
                 <b-button size="sm" @click="selectAllRows">Select all</!

                <b-form-checkbox
                    id="checkbox-1"
                    v-model="selectAll"
                    name="checkbox-1"
                    value="true"
                    unchecked-value="false"
                    @change="selectAllRows"
                    >
                </b-form-checkbox>
            </template> -->

            <template v-slot:cell(selected)="{ rowSelected }">

                <template v-if="rowSelected">
                <span aria-hidden="true">&check;</span>
                <span class="sr-only">Selected</span>
                </template>

                <template v-else>
                <span aria-hidden="true">&nbsp;</span>
                <span class="sr-only">Not selected</span>
                </template>

            </template>

            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
        </b-table>
        <b-button class="mt-3" block @click="move_to_page">Close Me</b-button>
    </div>

</template>
<script>
import { isNumber } from 'util';

import { serverBus } from '../app.js';

 export default {
    data() {
      return {
        show:false,
        isBusy: false,
        branchlist: [],
        filter: null,
        currentPage: 1,
        perPage: 10,
        totalRows: null,
        selectMode: 'single',
        fixed: true,
        selected: [],
        selectAll:false,
        align:'center',
        fields: [
                { key: 'selected'},
                { key: 'SUPP_SITE_CODE', label: 'Supp. Site Code', sortable: true },
                { key: 'SUPP_SITE_NAME', label: 'Supp. Site Name'},
                { key: 'TOTAL_BPB', label: 'Outs. BPB' }
            ],
        search: '',
        selectedSite:''
      }
    },
    mounted(){
        this.getResults();
    },
    methods: {
         getResults(ctx, callback) {
                this.isBusy = true;
                var suppId = this.$auth.user().supp_id;
                var orgId = this.$auth.user().org_id;
              axios.post('/branchlist',{
                    supp_id: suppId,
                    org_id: orgId
                })
              .then((res) => {
                        this.branchlist = res.data.branchlist
                        this.totalRows = res.data.length;
                        this.isBusy = false;
                    }, () => {
                        this.has_error = true
                         this.isBusy = false;
                    });

        },
        onRowSelected(items) {

            this.selected = items
            serverBus.$emit('siteSelected', Number(this.selected[0].SUPP_SITE_ID));
            // serverBus.$emit('siteSelected', this.selected);
            // console.log(this.selected)
        },
        move_to_page(){
            // alert(this.selected[0].SUPP_SITE_ID)
            var site_id = Number(this.selected[0].SUPP_SITE_ID);
            this.$bvModal.hide('modalSuppSite')

            //this.$emit("selectedSite", this.site-selected);

            //alert(site_id);

            // this.$router.push({ name: 'User.InputTTF',params: {SITE:this.selected[0].SUPP_SITE_ID }})

            // axios.post('/login', this.$data)
            //     .then(() => {
            //         window.location.href = '/home';
            // });
        }
    },
    created() {
        // this.loadUsers()
    }
  }

</script>
