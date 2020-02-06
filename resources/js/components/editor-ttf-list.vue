<template>
  <div>

    <b-table
    hover
    small
    responsive
    bordered
    :items="Prop_return_data"
    :fields="fields"
    :busy="isBusy"
    show-empty
    align="center"
    valign="middle"
    select-mode="multi"
    head-variant="dark"
    selectable
    selected-variant="warning"
    primary-key="bpb_number"
    @row-clicked="rowClicked"
    >
        <template v-slot:cell(selected)="{ value }" >
            <b-checkbox v-model="value"></b-checkbox>
        </template>

        <template v-slot:table-busy>
            <div class="text-center text-danger my-2">
                <b-spinner class="align-middle"></b-spinner>
                <strong>Loading...</strong>
            </div>
        </template>

        <template v-slot:cell(bpb_dpp)="row">
              {{ row.item.bpb_dpp | toCurrency }}
        </template>
        <template v-slot:cell(bpb_tax)="row">
              {{ row.item.bpb_tax | toCurrency }}
        </template>
    </b-table>

    <!-- <p>
        {{Prop_return_data}}
    </p> -->

  </div>
</template>

<script>
import { serverBus } from '../app.js';

  export default {
    data() {
      return {
        show:false,
        isBusy: false,
        disarm:false,
        ttf: [],
        filter: null,
        currentPage: 1,
        perPage: 10,
        totalRows: null,
        selectedID: null,
        align:'center',
        counter:0,
        fields: [
                { key: 'selected',label: ''},
                { key: 'bpb_number', label: 'No.BPB',sortable: true },
                { key: 'bpb_bkl', label: 'BPB BKL', sortable: true},
                { key: 'no_ref', label: 'No.Reff', sortable: true },
                { key: 'bpb_date', label: 'Tgl.BPB', sortable: true},
                { key: 'bpb_dpp', label: 'DPP BPB'},
                { key: 'bpb_tax', label: 'PPN BPB' }
            ]
        //     ,
        // items:this.selectedBPB
      }
    },
    mounted(){
    },
    props:{
        selectedBPB:Array
    },
    computed:{
        Prop_return_data(){
            for (var counter=0;counter<this.selectedBPB.length;counter++)
            {
                Vue.set(this.selectedBPB[counter], 'selected', false);
            }
            return this.selectedBPB;
        },
        selectedRows() {
            // this.selectedData = item;
            return this.Prop_return_data.filter(item => item.selected)
        }

    },
    methods: {
        rowClicked(item) {
            if(item.selected){
                this.$set(item, 'selected', false)
            }else{
                this.$set(item, 'selected', true)
            }
            //alert('here');
            serverBus.$emit('onEditorClick', this.selectedRows);
        },

    },
    created() {
    }
  }
</script>
