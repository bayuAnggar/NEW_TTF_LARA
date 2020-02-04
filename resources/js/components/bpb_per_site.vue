<template>
  <div>
    <b-container fluid>
    <!-- User Interface controls -->
        <b-row>
        <b-col lg="6" class="my-1">
            <b-form-group
            label="Filter"
            label-cols-sm="3"
            label-align-sm="right"
            label-size="sm"
            label-for="filterInput"
            class="mb-0"
            label-align="left"
            >
            <b-input-group size="sm">
                <b-form-input
                v-model="filter"
                type="search"
                id="filterInput"
                placeholder="Type to Search"
                ></b-form-input>

                <b-input-group-append>
                <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                </b-input-group-append>
            </b-input-group>
            </b-form-group>
        </b-col>

        <b-col lg="6" class="my-1">
            <!-- <b-form-group
            label="Filter On"
            label-cols-sm="3"
            label-align-sm="right"
            label-size="sm"
            description="Leave all unchecked to filter on all data"
            class="mb-0">
            <b-form-checkbox-group class="mt-1" v-model="filterOn">
                <b-form-checkbox value="BPB_NUM">No.BPB</b-form-checkbox>
                <b-form-checkbox value="BPB_BKL">BPB BKL</b-form-checkbox>
                <b-form-checkbox value="NO_REFF">No.Reff</b-form-checkbox>
            </b-form-checkbox-group>
            </b-form-group> -->

            <p align="right">
                Total BPB yang Dipilih : {{ selectedRows.length }}
            </p>
        </b-col>
        </b-row>
    </b-container>

    <b-table
    hover
    responsive
    bordered
    :items="bpb_site"
    :fields="fields"
    :busy="isBusy"
    :current-page="currentPage"
    :per-page="perPage"
    show-empty
    align="right"
    valign="middle"
    small
    select-mode="multi"
    head-variant="dark"
    selectable
    selected-variant="warning"
    @row-clicked="rowClicked"
    primary-key="bpb_number"
    :filter="filter"
    :filterIncludedFields="filterOn"
    @filtered="onFiltered"
         >

        <template v-slot:cell(bpb_dpp)="row">
              {{ row.item.bpb_dpp | toCurrency }}
        </template>
        <template v-slot:cell(bpb_tax)="row">
              {{ row.item.bpb_tax | toCurrency }}
        </template>

        <!-- @row-selected="onRowSelected"
            <template v-slot:cell(TTF_NUM)="row" >

            <b-button
            class="btn btn-danger btn-sm"
            @click="info(row.item, row.index, $event.target)"
            :disabled="disarm"
            >
                <div v-if="disarm" class="lds-dual-ring">
                    <b-spinner small></b-spinner>
                    <span class="sr-only">Loading...</span>
                </div>
                <span v-else>{{row.item.TTF_NUM}}</span>
            </b-button>
        </template> -->
         <!-- <template v-slot:cell(selected)="{ rowSelected }">

            <template v-if="rowSelected">
                <span aria-hidden="true">&check;</span>
                <span class="sr-only">Selected</span>
            </template>

            <template v-else>
                <span aria-hidden="true">&nbsp;</span>
                <span class="sr-only">Not selected</span>
            </template>

        </template> -->

        <template v-slot:cell(selected)="{ value }" >
            <b-checkbox v-model="value"></b-checkbox>
        </template>

      <template v-slot:table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner class="align-middle"></b-spinner>
          <strong>Loading...</strong>
        </div>
      </template>
    </b-table>

    <!-- <p>
       Amount of items selected: {{ selectedRows.length }}

    </p> -->


     <b-container fluid>
    <!-- User Interface controls -->
        <b-row>
        <b-col lg="6" class="my-1">
           <p align="left">
                <b-button variant="success" size="sm" @click="pilih_bpb_data">Pilih BPB</b-button>

                <b-button variant="danger" size="sm" @click="batal_pilih_bpb" >Batal</b-button>
            </p>
        </b-col>

        <b-col lg="6" class="my-1">
             <b-pagination
                v-model="currentPage"
                :total-rows="totalRows"
                :per-page="perPage"
                align="right"
                size="sm"
                class="my-0"
            ></b-pagination>


        </b-col>
        </b-row>
    </b-container>

    <P>
        {{selectedRows}}
    </P>
    </div>


</template>

<script>
import { serverBus } from '../app.js';

  export default {
    data() {
      return {
        show:false,
        isBusy: false,
        bpb_site:[],
        filter: null,
        currentPage: 1,
        perPage: 5,
        totalRows: null,
        selected: [],
        items: [],
        filter: null,
        filterOn: [],
        totalRows: 1,
        align:'center',
        fields: [
                { key: 'selected',label: ''},
                { key: 'bpb_number', label: 'No.BPB' },
                { key: 'bpb_bkl', label: 'BPB BKL', sortable: true},
                { key: 'no_ref', label: 'No.Reff', sortable: true },
                { key: 'bpb_date', label: 'Tgl.BPB', sortable: true},
                { key: 'bpb_dpp', label: 'DPP BPB', valign:'right'},
                { key: 'bpb_tax', label: 'PPN BPB', valign:'right'}
            ]
      }
    },
    props:{
        site:Number
    },
    mounted(){
        this.getResults();
        this.totalRows = this.bpb_site.length;
    },
    computed: {
      selectedRows() {
        return this.bpb_site.filter(item => item.selected)
        this.selectedData = item;      }
    },
    methods: {
        rowClicked(item) {
            if(item.selected){
                this.$set(item, 'selected', false)
            }else{
                this.$set(item, 'selected', true)
            }
        },
        tbodyRowClass(item) {
            if(item.selected){
            return ["b-table-row-selected", "table-primary", "cursor-pointer"]
            }else{
            return ["cursor-pointer"]
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },
         getResults(ctx, callback) {

            this.isBusy = true;
            var suppId = this.$auth.user().supp_id;
            var orgId = this.$auth.user().org_id;
            var supp_site_id =this.site;
            axios.post('/bpb_supplier',{
                    supp_id: suppId,
                    supp_site_id: supp_site_id,
                    org_id: orgId
            })
            .then((res) => {
                    this.bpb_site = res.data.bpb_data;
                    this.totalRows = res.data.bpb_data.length;
                    return this.bpb_site;
                }, () => {
                    this.has_error = true
                });

                this.isBusy = false;
            },
        batal_pilih_bpb(){
            alert('HAHAHAH');
            this.$bvModal.hide('modalBPBdata');
        },
        pilih_bpb_data(){
            alert(JSON.stringify(this.selectedRows) );
            // this.productSelected = product;
            serverBus.$emit('onChildClick', this.selectedRows);
            this.$bvModal.hide('modalBPBdata');
        }
    }
  }
</script>
