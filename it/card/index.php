<content id="content">
	<div v-if="pesan.teks !== null" :class="'alert alert-'+pesan.tipe+' fadeInUp animated'">
	   {{pesan.teks}}
	   <button type="button" class="close" aria-label="Close" @click="pesan.teks = null">
	      <span aria-hidden="true">&times;</span>
	   </button>
	</div>
	<div class="search">
      <div class="container-fluid">
         <div class="row">
         	<div class="col-lg-3 col-md-6 mb-2">
               <select class="form-control" v-model="search.phongban">
                  <option value="">--- Phòng Ban ---</option>
                  <option v-for="option in phongban" v-bind:value="option.id">Phòng {{ option.name }}</option>
               </select>
            </div>
            <div class="col-lg-3 col-md-6 mb-2">
               <input type="text" class="form-control" v-model="search.name" placeholder="Tên nhân viên">
            </div>
            <div class="col-lg-3 col-md-6 mb-2">
               <input type="text" class="form-control" v-model="search.card" placeholder="ID Card">
            </div>
         </div>
      </div>
   </div>
	<div class="table__wrapper table-responsive">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th></th>
					<th class="text-center" v-for="column in columns">
						<a @click="sortBy(column.value)">
					   	{{ column.name }}
					   	<i v-if="column.value==currentSort" v-bind:class="(currentSortDir=='asc') ? 'fa fa-sort-amount-asc' : 'fa fa-sort-amount-desc'"></i>
						</a>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(item, index) in sortedDevice" v-on:click="isi_form(item)">
					<td class="text-center" width="50">{{ index + 1 }}</td>
					<td class="text-center nowrap" width="200">{{ item.card }}</td>
					<td class="nowrap text-center" width="160">{{ item.phongban }}</td>
					<td class="nowrap">{{ item.name }}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="modal fade" id="addModal" tabindex="-1">
      <div class="modal-dialog">
         <form class="modal-content" method="POST" action="" enctype="multipart/form-data" @submit.prevent="add_card">
            <div class="modal-header">
               <h5 class="modal-title">Thêm mới</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Họ và Tên</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.name" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Phòng Ban</label>
                  <div class="col-sm-9">
                     <select class="form-control form-control-sm" v-model="form.idban">
                        <option value="">--- Chọn phòng ban ---</option>
                        <option v-for="option in phongban" v-bind:value="option.id">{{ option.name }}</option>
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">ID Card</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.card" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="resetForm()">Thoát</button>
               <button type="submit" class="btn btn-primary">Lưu Lại</button>
            </div>
         </form>
      </div>
   </div>
   <div class="modal fade" id="upModal" tabindex="-1">
      <div class="modal-dialog">
         <form class="modal-content" method="POST" action="" enctype="multipart/form-data" @submit.prevent="updata_card">
            <div class="modal-header">
               <h5 class="modal-title">Cập nhật thông tin</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Họ và Tên</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.name" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Phòng Ban</label>
                  <div class="col-sm-9">
                     <select class="form-control form-control-sm" v-model="form.idban">
                        <option value="">--- Chọn phòng ban ---</option>
                        <option v-for="option in phongban" v-bind:value="option.id">{{ option.name }}</option>
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">ID Card</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.card" class="form-control form-control-sm" autocomplete="off" readonly>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="resetForm()">Thoát</button>
               <button type="submit" class="btn btn-primary">Lưu Lại</button>
            </div>
         </form>
      </div>
   </div>
</content>
<button type="button" class="created" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus-circle"></i></button>
<script type="text/javascript">
   $(document).on('dblclick', 'tbody tr', function (){
      $('#upModal').modal('show');
   });
</script>
<script type="text/javascript">
new Vue({
  	el: "#content",
  	data: {
		url: 'localhost:8081/it/card/crud.php',
		items: [],
		phongban: [],
      search: { name: "", card: "", phongban: "" },
		pesan: {
			teks: null,
			tipe: null,
		},
      form: {
         id: null,
         idban: null,
         card: null,
			name: '',
		},
      currentSort:'card',
      currentSortDir:'asc',
      columns: [
         {name: 'ID Card', value: 'card'},
         {name: 'Phòng Ban', value: 'idban'},
         {name: 'Nhân Viên', value: 'name'},
      ],
	},
	mounted: function(){
		this.start_form();
		this.show_phongban();
		this.show_card();
	},
  	methods: {
  		show_phongban() {

			axios.get(this.url, {
				params: { work: 'phongban' }
			})

			.then(respon => {
				console.log(respon)

				let data 	  = respon.data
				this.phongban = data;
			})
			
			.catch(error => { console.log(error) })
		},
      show_card() {

         axios.get(this.url, {
            params: { work: 'card' }
         })

         .then(respon => {
            console.log(respon)

            let data   = respon.data
            this.items = data;
         })
         
         .catch(error => { console.log(error) })
      },
      start_form() {
         this.form.idban = '';
      },
      isi_form(item) {
         this.form.id      = item.id;
         this.form.idban   = item.idban;
         this.form.name    = item.name;
         this.form.card 	= item.card;
      },
      add_card() {
         let dataTambah = new FormData();

         dataTambah.append('work', 'add_card');
         dataTambah.append('idban', this.form.idban);
         dataTambah.append('name',  this.form.name);
         dataTambah.append('card',  this.form.card);

         axios.post(this.url, dataTambah)
            .then(respon => {

               let data = respon.data

               console.log(data)

               if (data.sukses) {
                  $('#addModal').modal('hide');

                  this.resetForm();
                  this.show_card();
                  this.pesan.teks = data.pesan
                  this.pesan.tipe = data.tipe

                  setTimeout(() => this.pesan.teks = null, 3000);
               }
            })
            .catch(error => {
               console.log(error)
            })
      },
      updata_card() {
         let dataInsert = new FormData();

         dataInsert.append('work', 'updata_card');
         dataInsert.append('id',    this.form.id);
         dataInsert.append('idban', this.form.idban);
         dataInsert.append('name',  this.form.name);
         dataInsert.append('card',  this.form.card);

         axios.post(this.url, dataInsert)
            .then(respon => {
               
               $('#upModal').modal('hide');

               let data = respon.data

               console.log(data)

               if (data.sukses) {
                  this.show_card();
               }

               this.pesan.teks = data.pesan
               this.pesan.tipe = data.tipe

               this.resetForm();

               setTimeout(() => this.pesan.teks = null, 3000);
            })
            .catch(error => {
               console.log(error)
            })
      },
      resetForm() {
			var self = this;
			Object.keys(this.form).forEach(function (key, index) {
				self.form[key] = '';
			});
		},
      sortBy: function(sortKey){
         if(sortKey === this.currentSort) {
            this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
         }
         this.currentSort = sortKey;
      }
   },
   computed: {
      filteredList() {
         return this.items.filter((item) => {
         	let filtered = true
            let filterPhongban = this.search.phongban

            var card = item.card.toLowerCase().includes(this.search.card.toLowerCase())
            var name = item.name.toLowerCase().includes(this.search.name.toLowerCase())

            if(filterPhongban && filterPhongban.length > 0){
               filtered = item.idban == filterPhongban
            }

            return card && name && filtered
         })
      },
      sortedDevice() {
         return this.filteredList.sort((a,b) => {
            let modifier = 1;
            
            if(this.currentSortDir === 'desc') modifier = -1;
            if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
            if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
            
            return 0;
         });
      }
   }
});
</script>