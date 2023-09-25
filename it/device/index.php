<style type="text/css">
    #add_newDevice{
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        background: rgba(0, 0, 0, 0.5);
    }
    #add_newDevice .modal-dialog{
        margin: 20% auto;
    }
</style>
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
               <select class="form-control" v-model="search.loaimay">
                  <option value="">--- Loại Máy ---</option>
                  <option v-for="option in loaimay" v-bind:value="option.id">{{ option.name }}</option>
               </select>
            </div>
            <div class="col-lg-3 col-md-6 mb-2">
               <input type="text" class="form-control" v-model="search.service_tag" placeholder="Mã thiết bị">
            </div>
            <div class="col-lg-3 col-md-6 mb-2">
               <input type="text" class="form-control" v-model="search.name" placeholder="Tên nhân viên">
            </div>
            <div class="col-lg-3 col-md-6 mb-2">
               <select class="form-control" v-model="search.phongban">
                  <option value="">--- Phòng Ban ---</option>
                  <option v-for="option in phongban" v-bind:value="option.id">Phòng {{ option.name }}</option>
               </select>
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
         <!-- <tr v-for="(item, index) in sortedDevice" v-on:click="isi_form(item)">
            <td class="text-center" width="30">{{ index + 1 }}</td>
            <td class="nowrap" width="180">{{ item.loaimay }}</td>
            <td class="nowrap">{{ item.name }}</td>
            <td class="nowrap text-center" width="160">{{ item.phongban }}</td>
            <td class="text-center" width="160">{{ item.service_tag }}</td>
            <td class="text-center" width="180">{{ item.express_code }}</td>
            <td class="text-center" width="160">{{ item.mac_address }}</td>
            <td class="text-center" width="100">{{ item.ngay_mua }}</td>
            <td class="nowrap text-center" width="100">{{ item.tinh_trang }}</td>
         </tr> -->

         <tr v-for="(item, index) in sortedDevice" v-on:click="isi_form(item)">
            <td class="text-center" width="30">{{ index + 1 }}</td>
            <td>
                <ul>
                    <li><a data-toggle="collapse" :href="`#device-${index + 1}`" role="button" aria-expanded="false" :aria-controls="`device-${index + 1}`">{{ item.loaimay }}</a></li>
                </ul>
                <ol class="collapse multi-collapse" :id="`device-${index + 1}`">
                    <li><dl class="d-flex"><dt>Code/IP</dt><dd>: {{ item.express_code }}</dd></dl></li>
                    <li><dl class="d-flex"><dt>MAC Address</dt><dd>: {{ item.mac_address }}</dd></dl></li>
                    <li><dl class="d-flex"><dt>Ngày Mua</dt><dd>: {{ item.ngay_mua }}</dd></dl></li>
                    <li><dl class="d-flex"><dt>Tình Trạng</dt><dd>: {{ item.tinh_trang }}</dd></dl></li>
                    <li><dl class="d-flex"><dt>Chi Tiết</dt><dd>: {{ item.details }}</dd></dl></li>
                </ol>
            </td>
            <td>
                <ul>
                    <li>{{ item.service_tag }}</li>
                </ul>
            </td>
            <td>
                <ul>
                    <li><div class="d-flex">{{ item.name }}</div></li>
                </ul>
            </td>
            <td>
                <ul>
                    <li>{{ item.phongban }}</li>
                </ul>
            </td>
         </tr>
       </tbody>
     </table>
   </div>
   <div class="modal fade" id="addModal" tabindex="-1">
      <div class="modal-dialog">
         <form class="modal-content" method="POST" action="" enctype="multipart/form-data" @submit.prevent="add_device">
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
                  <label class="col-sm-3 col-form-label col-form-label-sm">Loại Máy</label>
                  <div class="col-sm-9">
                     <select class="form-control form-control-sm" v-model="form.idmay" required id="deviceType">
                        <option value="">--- Chọn loại máy ---</option>
                        <option v-for="option in loaimay" v-bind:value="option.id">{{ option.name }}</option>
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Mã Thiết Bị</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.service_tag" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Code / IP</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.express_code" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">MAC Address</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.mac_address" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Ngày Mua</label>
                  <div class="col-sm-9">
                      <input type="date" v-model="form.ngay_mua" v-bind:data-date="form.ngay_mua1" data-date-format="DD/MM/YYYY" class="form-control form-control-sm" value="">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Tình Trạng</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.tinh_trang" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Chi Tiết</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.details" class="form-control form-control-sm" autocomplete="off">
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
         <form class="modal-content" method="POST" action="" enctype="multipart/form-data" @submit.prevent="updata_device">
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
                  <label class="col-sm-3 col-form-label col-form-label-sm">Loại Máy</label>
                  <div class="col-sm-9">
                     <select class="form-control form-control-sm" v-model="form.idmay" required>
                        <option value="">--- Chọn loại máy ---</option>
                        <option v-for="option in loaimay" v-bind:value="option.id">{{ option.name }}</option>
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Mã Thiết Bị</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.service_tag" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Code / IP</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.express_code" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">MAC Address</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.mac_address" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Ngày Mua</label>
                  <div class="col-sm-9">
                      <input type="date" v-model="form.ngay_mua" v-bind:data-date="form.ngay_mua1" data-date-format="DD/MM/YYYY" class="form-control form-control-sm" value="">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Tình Trạng</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.tinh_trang" class="form-control form-control-sm" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Chi Tiết</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.details" class="form-control form-control-sm" autocomplete="off">
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
   <div class="modal fade" id="add_newDevice" tabindex="-1">
      <div class="modal-dialog">
         <form class="modal-content" method="POST" action="" enctype="multipart/form-data" @submit.prevent="add_newDevice">
            <div class="modal-header">
               <h5 class="modal-title">Thêm thiết bị mới</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Tên Thiết Bị</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.deviceName" class="form-control form-control-sm" autocomplete="off">
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
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="resetForm()">Thoát</button>
               <button type="submit" class="btn btn-primary">Lưu Lại</button>
            </div>
         </form>
      </div>
   </div>
   <div class="modal fade" id="deleteModal" tabindex="-1">
      <div class="modal-dialog">
         <form class="modal-content" method="POST" action="" enctype="multipart/form-data" @submit.prevent="delete_device">
            <div class="modal-header">
               <h5 class="modal-title">Xóa thông tin</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Họ và Tên</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.name" class="form-control form-control-sm" autocomplete="off" disabled>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Phòng Ban</label>
                  <div class="col-sm-9">
                     <select class="form-control form-control-sm" v-model="form.idban" disabled>
                        <option value="">--- Chọn phòng ban ---</option>
                        <option v-for="option in phongban" v-bind:value="option.id">{{ option.name }}</option>
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Loại Máy</label>
                  <div class="col-sm-9">
                     <select class="form-control form-control-sm" v-model="form.idmay" required disabled>
                        <option value="">--- Chọn loại máy ---</option>
                        <option v-for="option in loaimay" v-bind:value="option.id">{{ option.name }}</option>
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Mã Thiết Bị</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.service_tag" class="form-control form-control-sm" autocomplete="off" disabled>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Code / IP</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.express_code" class="form-control form-control-sm" autocomplete="off" disabled>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">MAC Address</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.mac_address" class="form-control form-control-sm" autocomplete="off" disabled>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Ngày Mua</label>
                  <div class="col-sm-9">
                      <input type="date" v-model="form.ngay_mua" v-bind:data-date="form.ngay_mua1" data-date-format="DD/MM/YYYY" class="form-control form-control-sm" value="" disabled>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Tình Trạng</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.tinh_trang" class="form-control form-control-sm" autocomplete="off" disabled>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">Chi Tiết</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.details" class="form-control form-control-sm" autocomplete="off" disabled>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label col-form-label-sm">ID</label>
                  <div class="col-sm-9">
                     <input type="text" v-model="form.id" class="form-control form-control-sm" autocomplete="off" disabled>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="resetForm()">Hủy</button>
               <button type="submit" class="btn btn-danger">Xóa</button>
            </div>
         </form>
      </div>
   </div>
</content>
<?php $option = $_GET['option']; ?>
   <a href="it/device/export.php"><button type="button" class="created-export" id="exportData" ><i class="fa fa-sign-out"></i></button></a>

<?php
if ($option == 'export')
{
	include 'it/device/export.php';
} 
?>
<!-- <div class="created" id="exportData" tabindex="-1">
   <div class="modal-dialog">
      <form class="modal-content" method="POST" action="" enctype="multipart/form-data" @submit.prevent="exportData">
         <button type="submit" id="exportData" class="created-export"><i class="fa fa-sign-out"></i></button>
      </form>
   </div>
</div> -->
<button type="button" class="created-2" data-toggle="modal" data-target="#add_newDevice"><i class="fa fa-laptop"></i></button>
<button type="button" class="created" data-toggle="modal" data-target="#addModal"><i class="fa fa-user-plus"></i></button>
<script type="text/javascript">
   $(document).on('dblclick', 'tbody tr', function (){
      $('#upModal').modal('show');
   });
   $(document).on('click', 'tbody tr td button', function (){
      $('#deleteModal').modal('show');
   });
   
   $(document).on("change", 'input[type="date"]', function() {
      this.setAttribute(
         "data-date",
         moment(this.value, "YYYY-MM-DD")
         .format( this.getAttribute("data-date-format") )
      )
   }).trigger("change");
   // $('#addDevice').addEventListener("click", function(){
   //      $('#add_newDevice').modal('show');
   // });
</script>
<script type="text/javascript">
var highEstDeviceID = 0;
new Vue({
  	el: "#content",
  	data: {
		url: 'localhost:8081/it/device/crud.php',
		device: [],
      phongban: [],
      loaimay: [],
      search: {
         name: "", service_tag: "", loaimay: "", phongban: "", details:"",
      },
		pesan: {
			teks: null,
			tipe: null,
		},
      form: {
         id: null,
         idmay: null,
         idban: null,
         name: '',
         service_tag: '',
         express_code: '',
         mac_address: '',
         ngay_mua: '',
         tinh_trang: '',
         details: '',
		},
      currentSort:'phongban',
      currentSortDir:'asc',
      columns: [
         {name: 'Thiết Bị', value: 'loaimay'},
         {name: 'Mã Thiết Bị', value: 'service_tag'},
         {name: 'Nhân Viên', value: 'name'},
         {name: 'Phòng Ban', value: 'phongban'},
      ],
	},
	mounted: function(){
      this.start_form();
      this.show_loaimay();
      this.show_phongban();
		this.show_device();
      const button = document.getElementById('exportData');
      button.addEventListener('click', this.exportData);
	},
  	methods: {
      show_loaimay() {
         this.loading = true;

         axios.get(this.url, {
            params: { work: 'loaimay' }
         })

         .then(respon => {
            highEstDeviceID = Math.max(...respon.data.map(el => el.id));

            let data       = respon.data
            this.loaimay   = data;
         })
         
         .catch(error => { console.log(error) })
      },
      show_phongban() {
			this.loading = true;

			axios.get(this.url, {
				params: { work: 'phongban' }
			})

			.then(respon => {

				let data 	  = respon.data
				this.phongban = data;
			})
			
			.catch(error => { console.log(error) })
		},
      show_device() {
         this.loading = true;

         axios.get(this.url, {
            params: { work: 'device_it' }
         })

         .then(respon => {

            let data    = respon.data
            this.device = data;
         })
         
         .catch(error => { console.log(error) })
      },
      start_form() {
         this.form.idmay = '';
         this.form.idban = '';
      },
      isi_form(item) {
         this.form.id          = item.id;
         this.form.idmay       = item.idmay;
         this.form.idban       = item.idban;
         this.form.name        = item.name;
         this.form.service_tag = item.service_tag;
         this.form.express_code= item.express_code;
         this.form.mac_address = item.mac_address;
         this.form.ngay_mua    = moment(item.ngay_mua, 'DD/MM/YYYY').format('YYYY-MM-DD');
         this.form.ngay_mua1   = item.ngay_mua;
         this.form.tinh_trang  = item.tinh_trang;
         this.form.details     = item.details;
      },
      add_device() {
         let dataTambah = new FormData();

         dataTambah.append('work', 'add_device');
         dataTambah.append('idmay', this.form.idmay);
         dataTambah.append('idban', this.form.idban);
         dataTambah.append('name',  this.form.name);
         dataTambah.append('service_tag', this.form.service_tag);
         dataTambah.append('express_code',this.form.express_code);
         dataTambah.append('mac_address', this.form.mac_address);
         dataTambah.append('ngay_mua',    this.form.ngay_mua);
         dataTambah.append('tinh_trang',  this.form.tinh_trang);
         dataTambah.append('details',    this.form.details);

         axios.post(this.url, dataTambah)
            .then(respon => {

               let data = respon.data

               if (data.sukses) {
                  $('#addModal').modal('hide');

                  this.resetForm();
                  this.show_device();
                  this.pesan.teks = data.pesan
                  this.pesan.tipe = data.tipe

                  setTimeout(() => this.pesan.teks = null, 3000);
               }
            })
            .catch(error => {
               console.log(error)
            })
      },
      updata_device() {
         let dataInsert = new FormData();

         dataInsert.append('work', 'updata_device');
         dataInsert.append('id',    this.form.id);
         dataInsert.append('idmay', this.form.idmay);
         dataInsert.append('idban', this.form.idban);
         dataInsert.append('name',  this.form.name);
         dataInsert.append('service_tag', this.form.service_tag);
         dataInsert.append('express_code',this.form.express_code);
         dataInsert.append('mac_address', this.form.mac_address);
         dataInsert.append('ngay_mua',    this.form.ngay_mua);
         dataInsert.append('tinh_trang',  this.form.tinh_trang);
         dataInsert.append('details',    this.form.details);

         axios.post(this.url, dataInsert)
            .then(respon => {
               
               $('#upModal').modal('hide');

               let data = respon.data

               if (data.sukses) {
                  this.show_device();
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
      },
      add_newDevice() {
         let newDeviceForm = new FormData();
         newDeviceForm.append('work', 'add_newDevice');
         newDeviceForm.append('id', highEstDeviceID + 1);
         newDeviceForm.append('idban', this.form.idban);
         newDeviceForm.append('name', this.form.deviceName);

         axios.post(this.url, newDeviceForm)
            .then(respon => {

               let data = respon.data


               if (data.sukses) {
                  $('#add_newDevice').modal('hide');

                  this.show_loaimay();

                  setTimeout(() => this.pesan.teks = null, 3000);
               }
            })
            .catch(error => {
               console.log(error)
            })
      },
      delete_device() {
         let dataDelete = new FormData();
         dataDelete.append('work', 'delete_device');
         dataDelete.append('id', this.form.id);

         if (this.form) {
            axios.post(this.url, dataDelete)
               .then(respon => {
                  $('#deleteModal').modal('hide');
                  let data = respon.data;

                  if (data.sukses) {
                     this.show_device();
                  }

                  this.pesan.teks = data.pesan;
                  this.pesan.tipe = data.tipe;

                  this.resetForm();

                  setTimeout(() => this.pesan.teks = null, 3000);
                  console.log(respon);
               })
               .catch(error => {
                  console.log(error);
               });
         }
      },
   },
   computed: {
      filteredList() {
         return this.device.filter((item) => {
            let filtered = true
            let filterLoaimay  = this.search.loaimay, 
                filterPhongban = this.search.phongban

            var name          = item.name.toLowerCase().includes(this.search.name.toLowerCase())
            var service_tag   = item.service_tag.toLowerCase().includes(this.search.service_tag.toLowerCase())

            if(filterLoaimay && filterLoaimay.length > 0){
                filtered = item.idmay == filterLoaimay
            }
            
            if(filtered){
               if(filterPhongban && filterPhongban.length > 0){
                  filtered = item.idban == filterPhongban
               }
            }

            return name && service_tag && filtered
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

