<?php require "database.php" ?>
<?php require "header.php" ?>
<div class="container mt-5"id="app"v-clock>
	<h3 class="text-primary">Gestion de prêt bancaire</h3>
	<hr>
	<br>
	<div>
		<b-button id="show-btn" @click="showModal('my-modal')"><i class="bi-plus-circle-fill me-2"></i> Nouveau pret</b-button>
		<!-- modal ajout -->
		<b-modal ref="my-modal" hide-footer title="Ajouter un nouveau pret">
		  <div class="d-block text-center">
		    <form @submit.prevent="onSubmit">
		    	<div class="row">
		    		<div class="form-group mt-3 col-md-6">
				    	<label for="">N° de compte</label>
				    	<input type="text" v-model="num"class="form-control">
			    	</div>
			    	<div class="form-group mt-3 col-md-6">
				    	<label for="">Nom client</label>
				    	<input type="text" v-model="nom_cli"class="form-control">
			    	</div>
		    	</div>
		    	<div class="row">
		    		<div class="form-group mt-3 col-md-6">
				    	<label for="">Nom banque</label>
				    	<input type="text" v-model="nom_banque"class="form-control">
			    	</div>
			    	<div class="form-group mt-3 col-md-6">
				    	<label for="">Montant</label>
				    	<input type="number" v-model="montant"class="form-control">
			    	</div>
		    	</div>
		    	<div class="row">
		    		<div class="form-group mt-3 col-md-6">
				    	<label for="">Date</label>
				    	<input type="date" v-model="date"class="form-control">
			    	</div>
			    	<div class="form-group mt-3 col-md-6" >
				    	<label for="">Taux</label>
				    	<input type="number" v-model="taux"class="form-control">
			    	</div>
		    	</div>
		    	<br>
		    	<div class="form-group">
		    		<button class="btn btn-outline-success btn-sm mt-3 ms-2"style="float: right;">Enregistrer</button>
		    	</div>
		    </form>
		  </div>
		  <b-button class="mt-3" variant="outline-danger btn-sm" block @click="hideModal('my-modal')"style="float:right;">Fermer</b-button>
		</b-modal>
		<!-- modal modifier -->
		<b-modal ref="my-modal-edit" hide-footer title="Ajouter un nouveau pret">
		  <div class="d-block text-center">
		    <form @submit.prevent="onUpdate">
		    	<div class="row">
		    		<div class="form-group mt-3 col-md-6">
				    	<label for="">N° de compte</label>
				    	<input type="text" v-model="edit_num"class="form-control">
			    	</div>
			    	<div class="form-group mt-3 col-md-6">
				    	<label for="">Nom client</label>
				    	<input type="text" v-model="edit_nom_cli"class="form-control">
			    	</div>
		    	</div>
		    	<div class="row">
		    		<div class="form-group mt-3 col-md-6">
				    	<label for="">Nom banque</label>
				    	<input type="text" v-model="edit_nom_banque"class="form-control">
			    	</div>
			    	<div class="form-group mt-3 col-md-6">
				    	<label for="">Montant</label>
				    	<input type="number" v-model="edit_montant"class="form-control">
			    	</div>
		    	</div>
		    	<div class="row">
		    		<div class="form-group mt-3 col-md-6">
				    	<label for="">Date</label>
				    	<input type="date" v-model="edit_date"class="form-control">
			    	</div>
			    	<div class="form-group mt-3 col-md-6" >
				    	<label for="">Taux</label>
				    	<input type="number" v-model="edit_taux"class="form-control">
			    	</div>
		    	</div>
		    	<br>
		    	<div class="form-group">
		    		<button class="btn btn-outline-success btn-sm mt-3 ms-2"style="float: right;">Enregistrer</button>
		    	</div>
		    </form>
		  </div>
		  <b-button class="mt-3" variant="outline-danger btn-sm" block @click="hideModal('my-modal-edit')"style="float:right;">Fermer</b-button>
		</b-modal>
	</div>
	<!-- table -->
	<table v-if="pret.length"class="table mt-3 table-striped table-sm table-bordered text-center"style="box-shadow: none !important;">
		<thead class="bg-success text-light">
			<tr>
				<th>Nom client</th>
				<th>Nom banque</th>
				<th>Montant</th>
				<th>Date prêt</th>
				<th>Montant à payer</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="p in pret":key="p.Ncompte">
				<td>{{p.nom_cli}}</td>
				<td>{{p.nom_banque}}</td>
				<td>{{p.montant}} Ar</td>
				<td>{{p.date_pret}}</td>
				<td>{{calculmt(p.montant,p.taux_pret)}}Ar</td>
				<td>
					<button v-on:click="editPret(p.Ncompte)"class="btn btn-primary btn-sm"><i class="bi-pen"></i> Editer</button>
					<button v-on:click="deletePret(p.Ncompte)"class="btn btn-danger btn-sm"><i class="bi-trash"></i> Supprimer</button>
				</td>
			</tr>
		</tbody>
	</table>
	<div v-if="pret.length">
		<p>Total montant à payer: {{total}} Ar</p>
		<p>Maximum du montant à payer: {{max}} Ar</p>
		<p>Minimum du montant à payer: {{min}} Ar</p>
	</div>
</div>
<!-- js -->
<script src="js/vue.min.js"></script>
<script src="js/bootstrap-vue.min.js"></script>
<script src="js/axios.min.js"></script>
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/sweetalert.init.js"></script>
<script src="js/sweetalert2.all.js"></script>
<script>
  	var app=new Vue({
  		el:'#app',
  		data:{
  			total:0,
  			max:0,
  			min:0,
  			pret:[],
  			montant_payer:'',
  			num:'',
  			nom_cli:'',
  			nom_banque:'',
  			montant:'',
  			date:'',
  			taux:'',
  			edit_num:'',
  			edit_nom_cli:'',
  			edit_nom_banque:'',
  			edit_montant:'',
  			edit_date:'',
  			edit_taux:'',
  			numtemp:'',
  			c:'',
  			donne:[],
  		},
  		methods: {
			calculmt:function(a,b)
			{
				return a*(1+(b/100));
			},
	      showModal(modal) {
	        this.$refs[modal].show()
	      },
	      hideModal(modal) {
	        this.$refs[modal].hide()
	      },
	      getPret()
		  {
		    axios({
		    	url:'affichage.php',
		    	method:'get'
		    })
		    .then(res =>{
		    	this.pret=res.data.rows;
		    	this.total=res.data.somme;
		    	this.min=res.data.min;
		    	this.max=res.data.max;
		    })
		    .catch(err =>{
		    	console.log(err)
		    })
		  },
		  deletePret(numeroCpte)
		  {
		  	swal({
		        title: "Vous êtes sûr de vouloir supprimer cet prêt?",
		        text: "vous ne pouvez plus récupérer ces données apès la suppression!",
		        type: "warning",
		        showCancelButton: true,
		        cancelButtonText:"Annuler",
		        cancelButtonColor:"var(--bs-success)",
		        confirmButtonColor:"var(--bs-danger)",
		        confirmButtonClass: "btn btn-success",
		        cancelButtonClass: "btn btn-danger",
		        confirmButtonText: "Supprimer",
		      }).then((result)=> {
		        	if(result.value)
		        	{
		        		var form=new FormData();
				  		form.append('num',numeroCpte);
				  		axios({
				  			url:'delete.php',
				  			method:'post',
				  			data:form
				  		})
				  		.then(res=>{
				  			if (res.data.res=="success") {
				  				swal({
						        title: "Très Bien",
						        text: "Les données sont supprimer avec succèes",
						        type: "success",
						        confirmButtonClass: "btn btn-success",
						      	});
				  				this.getPret();
				  			}
				  		})
				  		.catch(err=>{
				  			console.log(err)
				  		})
		        	}
		      });
		  },
		  editPret(numeroCpte)
		  {
		  	var form=new FormData();
		  	form.append('num',numeroCpte);
		  	axios({
		  		url:'selectedit.php',
		  		method:'post',
		  		data:form,
		  	})
		  	.then(res=>{
		  		if (res.data.res=="success") {
		  			this.edit_num=res.data.row[0];
		  			this.edit_nom_cli=res.data.row[1];
		  			this.edit_nom_banque=res.data.row[2];
		  			this.edit_montant=res.data.row[3];
		  			this.edit_date=res.data.row[4];
		  			this.edit_taux=res.data.row[5];
		  			this.numtemp=this.edit_num;
		  			this.showModal('my-modal-edit')
		  		}
		  	})
		  	.catch(err=>{
		  		console.log(err)
		  	})
		  },
		  onSubmit()
		  {
		  	if(this.num !=='' && this.nom_cli !==''&& this.nom_banque !==''&& this.montant !==''&&this.date!=='' && this.taux!=='')
		  	{
		  		var form=new FormData();
		  		form.append('num',this.num);
		  		form.append('nom_cli',this.nom_cli);
		  		form.append('nom_banque',this.nom_banque);
		  		form.append('montant',this.montant);
		  		form.append('date',this.date);
		  		form.append('taux',this.taux);
		  		axios({
		  			url:'insert.php',
		  			method:'post',
		  			data:form
		  		})
		  		.then(res=>{
		  			if (res.data.res=="success") {
	  				swal({
			        title: "Très Bien",
			        text: "Les données sont insérer avec succèes",
			        type: "success",
			        confirmButtonClass: "btn btn-success",
			      	});
			  		this.num='',
			  		this.nom_cli='',
			  		this.nom_banque='',
			  		this.montant='',
			  		this.taux='',
			  		this.date='',
			  		this.montant=''
			  		this.hideModal('my-modal');
			  		this.getPret();
		  			}
		  		})
		  		.catch(err=>{
		  			console.log(err)
		  		})
		  	}else
		  	{
		  		swal({
			        type: "error",
			        title: "Oops...",
			        text: "Tous les champs sont obligatoires",
			      });
		  	}
		  },
		  onUpdate()
		  {
		  	if(this.edit_num !=='' && this.edit_nom_cli !==''&& this.edit_nom_banque !==''&& this.edit_montant !==''&&this.edit_date!=='' && this.edit_taux!=='')
		  	{
			  	var form=new FormData()
			  	form.append('edit_num',this.edit_num);
			  	form.append('edit_nom_cli',this.edit_nom_cli);
			  	form.append('edit_nom_banque',this.edit_nom_banque);
			  	form.append('edit_montant',this.edit_montant);
			  	form.append('edit_date',this.edit_date);
			  	form.append('edit_taux',this.edit_taux);
			  	form.append('numtemp',this.numtemp);

			  	axios({
			  		url:'update.php',
			  		method:'post',
			  		data:form
			  	})
			  	.then(res=>{
			  		if(res.data.res=="success")
			  		{
			  			swal({
				        title: "Très Bien",
				        text: "Les données ont été mise à jour avec succèes",
				        type: "success",
				        confirmButtonClass: "btn btn-success",
				      	});
				  		this.hideModal('my-modal-edit');
				  		this.getPret();
			  		}
			  	})
			  	.catch(err=>{
			  		console.log(err)
			  	})
			}else
		  	{
		  		swal({
			        type: "error",
			        title: "Oops...",
			        text: "Tous les champs sont obligatoires",
			      });
		  	}
		  }
	    },
	    mounted:function()
	    {
	    	this.getPret()
	    }
  	})
    
</script>
<?php require "footer.php" ?>