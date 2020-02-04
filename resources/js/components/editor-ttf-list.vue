<template>
  <div>

    <b-table
    hover
    small
    responsive
    bordered
    :items="BPB"
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
              {{ row.BPB.bpb_dpp | toCurrency }}
        </template>
        <template v-slot:cell(bpb_tax)="row">
              {{ row.BPB.bpb_tax | toCurrency }}
        </template>
    </b-table>

    <p>
        {{selectedBPB}}
    </p>

  </div>
</template>

<script>
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
        BPB:[],
        align:'center',
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
        this.BPB = this.selectedBPB;
    },
    props:{
        selectedBPB:Array
    },
    methods: {
         getResults(ctx, callback) {
                this.isBusy = true;
                var suppId = this.$auth.user().supp_id;
                var orgId = this.$auth.user().org_id;
              axios.post('/ttf',{
                    supp_id: suppId,
                    org_id: orgId
                })
              .then((res) => {
                        this.ttf = res.data.ttf
                        this.totalRows = res.data.length;

                        //CHECK USER PERLU GANTI PASSWORD TO GA//
                        if(this.$auth.user().reset_flag == 'Y')
                        {
                            this.show = true
                        }

                        return this.ttf;

                    }, () => {
                        this.has_error = true
                    });
                // this.$http({
                //     url: 'ttf/${this.$auth.user().supp_id}',
                //     method: 'POST'
                //     })
                //     .then((res) => {
                //         this.ttf = res.data.ttf
                //         this.totalRows = res.data.length;
                //         return this.ttf;
                //     }, () => {
                //         this.has_error = true
                //     });
                     this.isBusy = false;
            },
        createUser(){
            alert('HAHAHAH');
        }
    },
    created() {
        // this.loadUsers()
    }
  }
</script>
