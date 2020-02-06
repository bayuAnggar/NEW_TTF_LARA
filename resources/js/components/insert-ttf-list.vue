<template>
  <div>

    <b-table hover responsive bordered :items="ttf" :fields="fields" :busy="isBusy" show-empty align="center" valign="middle"  >
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
        </template>

      <template v-slot:table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner class="align-middle"></b-spinner>
          <strong>Loading...</strong>
        </div>
      </template>
    </b-table>

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
        align:'center',
        fields: [
                { key: 'TYPE_FAKTUR', label: 'Tipe Faktur Pajak' },
                { key: 'NO_FP', label: 'Nomor Faktur Pajak', sortable: true},
                { key: 'FP_DATE', label: 'Tgl.Faktur Pajak', sortable: true },
                { key: 'DPP_FP', label: 'DPP Faktur Pajak', sortable: true},
                { key: 'PPN_FP', label: 'PPN Faktur Pajak', sortable: true},
                { key: 'TOTAL_BPB', label: 'Total Bundle BPB' },
                { key: 'SELISIH_DPP', label: 'Selisih DPP' },
                { key: 'SELISIH_PPN', label: 'Selisih PPN' }
            ]
      }
    },
    mounted(){
        // this.getResults();
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
